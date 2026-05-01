<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Models\MembershipPlan;
use App\Models\Transaction;
use App\Models\UserMembershipDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpiredPlanController extends Controller
{
    public function index()
    {
        return view('admin.expiredplan.index', [
            'plans' => UserMembershipDetail::filter(request())->expiredPlanWithOrderByCondition(request('orderby'))->paginate(50)->withQueryString(),
            'request' => request()
        ]);
    }

    public function create(UserMembershipDetail $plan)
    {
        return view('admin.expiredplan.create', [
            'currentPlan' => $plan,
            'plans' => MembershipPlan::isActive()->get(),
            'paymentMethods' => PaymentMethod::getPaymentMethod()
        ]);
    }

    public function store(UserMembershipDetail $plan, Request $request)
    {
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
            return to_route(Auth::user()->roleName . 'user.index');
        } catch (Exception $e) {
            flash('Something went wrong. Unable to renew plan', 'error');
            return to_route(Auth::user()->roleName . 'expired.plan.index');
        }
    }
}
