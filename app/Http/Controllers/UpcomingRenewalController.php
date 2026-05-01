<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Models\MembershipPlan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserMembershipDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpcomingRenewalController extends Controller
{
    public function index()
    {
        return view('admin.upcomingrenewal.index', [
            // 'plans' => UserMembershipDetail::planExpiringsoon()->paginate(50)
            'plans' => UserMembershipDetail::filter(request())->planExpiringsoonWithOrderByCondition(request('orderby'))->paginate(50),
        ]);
    }

    public function create($id)
    {
        $plan = UserMembershipDetail::find($id);
        return view('admin.upcomingrenewal.create', [
            'currentPlan' => $plan,
            'plans' => MembershipPlan::isActive()->get(),
            'paymentMethods' => PaymentMethod::getPaymentMethod()
        ]);
    }

    public function store($id, Request $request)
    {
        $plan = UserMembershipDetail::find($id);
        try {
            DB::transaction(function () use ($plan, $request) {
                UserMembershipDetail::create([
                    'user_id' => $plan->user->id,
                    'name' => $request->membership_duration,
                    'amount' => $request->amount,
                    'remaining_amount' => $request->remaining_amount,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'notes' => $request->note
                ]);

                Transaction::create([
                    'user_id' => $plan->user->id,
                    'transaction_date' => today(),
                    'method_type' => $request->method_type,
                    'created_by' => Auth::id(),
                    'amount' => $request->amount
                ]);
            });

            flash('Plan renewed successfully', 'success');
            return to_route(Auth::user()->roleName . 'upcoming.renewal.index');
        } catch (Exception $e) {
            flash('Something went wrong. Unable to renew plan', 'error');
            return to_route(Auth::user()->roleName . 'upcoming.renewal.index');
        }
    }
    public function update(UserMembershipDetail $plan)
    {
        try {
            $plan->update([
                'interest_status'=>UserMembershipDetail::NOT_INTERESTED,
            ]);
            flash('Status updated successfully', 'success');
            return back();
        } catch (Exception $e) {
            flash('Something went wrong. Unable to update Status', 'error');
            return back();
        }
    }
}
