<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Enum\LiabilityRange;
use App\Enum\PaymentMethod;
use App\Enum\UserType;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Branch;
use App\Models\LeadNotes;
use App\Models\LeadUser;
use App\Models\MembershipPlan;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserMembershipDetail;
use App\Models\UserNote;
use App\Models\UserProfile;
use App\Services\UserService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View
    {
        return view('admin.user.index', [
            'users' => User::indexArrangedData(request('orderby'))
                ->paginate(50)
                ->withQueryString(),
            'user_types' => UserType::getUserType(),
            'request' => request(),
            'activeMaleFemaleCount'=>User::activeMemberCount(),
            'plans'=>MembershipPlan::isActive()->orderBy('validity')->pluck('name')->toArray(),
            'monthMembershipCount'=>user::monthMembershipCount(),
            'liabilityRange'=>LiabilityRange::getLiabilityRange(),
        ]);
    }

    public function search(Request $request)
    {
        $search = trim((string) $request->input('search', ''));

        if ($search === '') {
            return response()->json(['data' => []]);
        }

        $users = User::query()
            ->isUser()
            ->with(['userProfile', 'image', 'membershipDetails'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($nestedQuery) use ($search) {
                    $nestedQuery->where('phone', 'LIKE', '%' . $search . '%')
                        ->orWhere('member_id', 'LIKE', '%' . $search . '%')
                        ->orWhereHas('userProfile', function ($profileQuery) use ($search) {
                            $profileQuery->where('first_name', 'LIKE', '%' . $search . '%')
                                ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                        });
                });
            })
            ->orderByDesc('id')
            ->limit(8)
            ->get()
            ->map(function (User $user) {
                $membership = $user->membershipDetails;
                $remainingAmount = (float) ($membership->remaining_amount ?? 0);

                return [
                    'id' => $user->id,
                    'member_id' => $user->member_id,
                    'full_name' => $user->userProfile->fullName ?? '',
                    'phone' => $user->phone,
                    'image_url' => optional($user->image)->path ? profileImage($user->image->path) : null,
                    'membership_name' => $membership->name ?? null,
                    'membership_amount' => $membership->amount ?? null,
                    'remaining_amount' => $membership->remaining_amount ?? null,
                    'start_date' => $membership->start_date ? Carbon::parse($membership->start_date)->format('d/m/Y') : null,
                    'end_date' => $membership->end_date ? Carbon::parse($membership->end_date)->format('d/m/Y') : null,
                    'status' => $remainingAmount <= 0
                        ? 'COMPLETED'
                        : ((isset($membership->end_date) && Carbon::parse($membership->end_date)->isPast()) ? 'EXPIRED' : 'ACTIVE'),
                    'view_url' => route(auth()->user()->roleName . 'user.view', $user),
                ];
            });

        return response()->json(['data' => $users]);
    }

    public function view(User $user): View
    {
        return view('admin.user.view', [
            'user' => $user,
        ]);
    }

    public function create(LeadUser $user): View
    {
        return view('admin.user.create', [
            'roles' => Role::isUser()->get(),
            'branches' => Branch::get(),
            'plans' => MembershipPlan::isActive()->orderby('validity')->get(),
            'paymentMethods' => PaymentMethod::getPaymentMethod(),
            'lead' => $user ?? null
        ]);
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        $request->validate([
            'membership_duration' => 'required',
            'amount' => 'required',
            'remaining_amount' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'method_type' => 'required'
        ]);

        $user = $this->userService->createUser($request);

        if ($request->note) {
            UserNote::create([
                'note_type' => 1,
                'user_id' => $user->id,
                'note' => $request->note,
            ]);
        }
        //when lead is converted to member then lead should be deleted || record from leadNotes also deleted automatically
        //as migration contains ->cascadeondelete()
        //for that RemoveClosedLead observer is running (event)---->
        //
        if ($user) {
            // If user is created then redirect to users listiong
            flash('Member created successfully.', 'success');
            return to_route(Auth::user()->rolename . 'user.index');
        }

        // Else return back with error
        flash('Something went wrong! Unable to create member', 'error');
        return back();
    }

    public function edit(User $user): View
    {
        return view('admin.user.edit', [
            'user' => $user,
            'roles' => Role::isUser()->get(),
            'branches' => Branch::get(),
            'plans' => MembershipPlan::orderBy('validity')->isActive()->get(),
            'paymentMethods' => PaymentMethod::getPaymentMethod()
        ]);
    }

    public function exit(User $user): RedirectResponse
    {
        try {
            $user->exit_status = !$user->exit_status;
            $user->save();

            $message = $user->exit_status
                ? 'Member exited successfully'
                : 'Member rejoined successfully';

            return back()->with('success', $message);
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to update member exit status due to an issue.', 'error');
            return back();
        }
    }

    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {
        // if user is updated then move forward
        $updatedUser = $this->userService->updateUser($user, $request);
        if ($updatedUser) {
            // if user have USER role then move forward
            flash('Member updated successfully', 'success');
            return to_route(Auth::user()->rolename . 'user.index');
        }

        // else return back with error
        flash('Something went wrong! Unable to update member', 'error');
        return back();
    }

    public function delete(User $user): RedirectResponse
    {
        try {
            $user->userProfile->delete();
            $user->delete();
            flash('Member deleted successfully!', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to delete member due to some issue.', 'error');
            return back();
        }
    }
    public function deleteRecord($id): RedirectResponse{
        $userMembershipDetail = UserMembershipDetail::find($id);
        $transaction = Transaction::where('user_id',$userMembershipDetail->user_id)->where('created_at',$userMembershipDetail->created_at)->first();
        try {
            $userMembershipDetail->delete();
            $transaction->delete();
            flash('Record deleted successfully!', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to delete record due to some issue.', 'error');
            return back();
        }
    }
}
