<?php

namespace App\Http\Controllers;

use App\Enum\LeadSource;
use App\Models\Branch;
use App\Models\LeadNotes;
use App\Models\LeadUser;
use App\Models\Media;
use App\Models\MembershipPlan;
use App\Models\Template;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LeadUserController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.lead.index', [
            'users' => LeadUser::with(['createdBy', 'notes', 'createdByProfile', 'assignedTo.assignedProfile'])
                ->filter($request)
                ->orderBy('id', 'desc')
                ->paginate(50),
            'request' => $request,
            'templates'=>Template::get(),
            'staff' => User::with('userProfile')->where('role_id', 2)->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.lead.create', [
            'plans' => MembershipPlan::orderBy('validity')->isActive()->get(),
            'sources' => LeadSource::getLeadSource(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'nullable',
            'gender' => 'required',
            'phone' => 'required|digits:10|numeric|unique:lead_users,phone',
            'membership_interested' => 'required',
            'note' => 'nullable|min:0',
            'amount_offer' => 'nullable',
            'follow_up_date' => 'required|date',
            'source' => 'nullable',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = LeadUser::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'follow_up_date' => $request->follow_up_date,
                    'amount_offer' => $request->amount_offer,
                    'source' => $request->source,
                    'membership_interested' => $request->membership_interested,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'assigned_to' => Auth::id(),
                ]);

                if ($request->note) {
                    LeadNotes::create([
                        'note' => $request->note,
                        'created_by' => Auth::id(),
                        'lead_id' => $user->id
                    ]);
                }
                if($request->profile_image){
                    $media = Media::make([
                        'name' => $request->file('profile_image')->getClientOriginalName(),
                        'path' => storeImage($request->file('profile_image')),
                        'type' => 'png',
                        'size' => $request->file('profile_image')->getSize()
                    ]);
                    $media->imageable()->associate($user);
                    $media->save();
                }
                
            });

            flash('Lead created successfully', 'success');
            return to_route(Auth::user()->roleName . 'lead.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to create lead', 'error');
            return back();
        }
    }

    public function edit(LeadUser $user): View
    {
        return view('admin.lead.edit', [
            'user' => $user,
            'branches' => Branch::get(),
            'plans' => MembershipPlan::isActive()->get(),
            'sources' => LeadSource::getLeadSource(),
        ]);
    }

    public function update(LeadUser $user, Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'nullable',
            'gender' => 'required',
            'phone' => 'required|min:0|integer',
            'membership_interested' => 'required',
            'note' => 'nullable|min:0',
            'follow_up_date' => 'nullable|date',
            'source' => 'nullable'
        ]);

        try {
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'membership_interested' => $request->membership_interested,
                'amount_offer' => $request->amount_offer,
                'follow_up_date' => $request->follow_up_date,
                'updated_by' => Auth::id(),
                'source' => $request->source,
            ]);
             if($request->follow_up_date){
                $lead_notes=LeadNotes::where('lead_id',$user->id)->get()->last();
                $lead_notes->update([
                    'next_follow_up_date'=>$request->follow_up_date
                ]);
             }

            if ($request->file('image') && $user->image->path) {
                $user->image->update([
                    'path' => storeImage($request->file('image'), $user->image->path),
                    'type' => 'png',
                    'size' => $request->file('image')->getSize()
                ]);
            } elseif ($request->file('image')) {
                $media = Media::make([
                    'name' => $request->file('image')->getClientOriginalName(),
                    'path' => storeImage($request->file('image')),
                    'type' => 'png',
                    'size' => $request->file('image')->getSize()
                ]);

                $media->imageable()->associate($user);
                $media->save();
            }

            flash('Lead updated successfully', 'success');
            return to_route(Auth::user()->roleName . 'lead.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to update lead', 'error');
            return back();
        }
    }

    public function view(LeadUser $user): View
    {
        return view('admin.lead.view', [
            'user' => $user,
        ]);
    }

    public function delete(LeadUser $user)
    {
        try {
            $user->delete();

            flash('Lead deleted successfully', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Somrthing went wrong. Unable to delete lead', 'error');
            return back();
        }
    }
}
