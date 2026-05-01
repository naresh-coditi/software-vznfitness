<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Models\MembershipPlan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserMembershipDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddMembershipPlanController extends Controller
{
    public function create(User $user)
    {
        return view('admin.user.membership.create', [
            'plans' => MembershipPlan::isActive()->orderby('validity')->get(),
            'paymentMethods' => PaymentMethod::getPaymentMethod(),
            'user' => $user,
            'membershipPlans' => $user->membershipPlans()->latest()->paginate(20)
        ]);
    }

    public function store(User $user, Request $request)
    {
        $request->validate([
            'membership_duration' => 'required',
            'amount' => 'required',
            'remaining_amount' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'method_type' => 'required'
        ]);

        try {
            DB::transaction(function () use ($user, $request) {
                UserMembershipDetail::create([
                    'user_id' => $user->id,
                    'name' => $request->membership_duration,
                    'amount' => $request->amount,
                    'remaining_amount' => $request->remaining_amount,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'notes' => $request->note
                ]);

                Transaction::create([
                    'user_id' => $user->id,
                    'transaction_date' => today(),
                    'method_type' => $request->method_type,
                    'created_by' => Auth::id(),
                    'amount' => $request->amount
                ]);
            });

            flash('Membership plan create successfully', 'success');
            return back();
        } catch (\Throwable $th) {
            flash('Something went wrong! Unable to create plan', 'error');
            Log::error($th->getMessage());
            return back();
        }
    }

    public function edit(UserMembershipDetail $plan)
    {
        $plan->load('user');

        return view('admin.user.membership.edit', [
            'plans' => MembershipPlan::isActive()->get(),
            // 'paymentMethods' => PaymentMethod::getPaymentMethod(),
            'plan' => $plan
        ]);
    }

    public function update(UserMembershipDetail $plan, Request $request)
    {
        try {
            $plan->update([
                'name' => $request->membership_duration,
                'amount' => $request->amount,
                'remaining_amount' => $request->remaining_amount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'notes' => $request->note
            ]);

            flash('Membership plan updated successfully', 'success');
            return back();
        } catch (\Throwable $th) {
            flash('Something went wrong! Unable to update plan', 'error');
            Log::error($th->getMessage());
            return back();
        }
    }

    public function delete(UserMembershipDetail $plan)
    {
        try {
            $plan->delete();

            flash('User membership plan deleted successfully', 'success');
            return back();
        } catch (\Throwable $th) {
            flash('Something went wrong! unable to delete membership plan', 'error');
            Log::error($th->getMessage());
            return back();
        }
    }
}
