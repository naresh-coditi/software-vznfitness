<?php

namespace App\Services;

use App\Enum\PaymentMethod;
use App\Enum\UserType;
use App\Models\MembershipPlan;
use App\Models\OnlineTransaction;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddMembershipService
{
    public function attachDates(Request $request)
    {
        $selectedPlans = collect();
        if (!$request->plans) {
            flash('Please select at least one plan', 'error');
            return back();
        }
        for ($index = 0; $index < count($request->plans); $index++) {
            $plan  = MembershipPlan::where('id', $request->plans[$index])->first();
            $plan->setAttribute('start_date', changeDateFromFormat($request->selected_date[$index]));
            $plan->setAttribute('end_date', addDaysFromFormat($request->selected_date[$index], $plan->validity));
            $selectedPlans->push($plan);
        }

        return $selectedPlans;
    }

    public function addPlanViaOnline(Request $request, $response, $user)
    {
        DB::transaction(function () use ($request, $response, $user) {
            $transaction = OnlineTransaction::create([
                'transaction_id' => $response->id,
                'amount' => $response->amount / 100,
                'status' => $response->status
            ]);

            $order = Order::create([
                'user_id' => $user->id,
                'method_type' => PaymentMethod::ONLINE['value'],
                'created_by' => Auth::id() ?? $user->id,
                'updated_by' => Auth::id() ?? $user->id,
            ]);

            OrderTransaction::create([
                'order_id' => $order->id,
                'transaction_id' => $transaction->id
            ]);

            $orders = array_map(function ($plan) use ($order) {
                $data = json_decode($plan);
                $membership = MembershipPlan::whereId($data->id)->first();

                return  new OrderItem([
                    'order_id' => $order->id,
                    'status' => 'succeeded',
                    'name' =>  $membership->name,
                    'validity' => $membership->validity,
                    'start_date' => dateFormat($data->start_date, 'Y-m-d'),
                    'end_date' => dateFormat($data->end_date, 'Y-m-d'),
                    'amount' => $membership->cost,
                ]);
            }, $request->plans);

            $order->orderItems()->saveMany($orders);

            if ($user->user_type === 0) {
                $user->update([
                    'user_type' => UserType::MEMBER['value']
                ]);
            }
        });
    }

    public function addPlanViaCash(Request $request, $user)
    {
        DB::transaction(function () use ($request, $user) {

            $order = Order::create([
                'user_id' => $user->id,
                'method_type' => PaymentMethod::CASH['value'],
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            $orders = array_map(function ($plan) use ($order) {
                $data = json_decode($plan);
                $membership = MembershipPlan::whereId($data->id)->first();

                return  new OrderItem([
                    'order_id' => $order->id,
                    'status' => 'succeeded',
                    'name' =>  $membership->name,
                    'validity' => $membership->validity,
                    'start_date' => dateFormat($data->start_date, 'Y-m-d'),
                    'end_date' => dateFormat($data->end_date, 'Y-m-d'),
                    'amount' => $membership->cost,
                ]);
            }, $request->plans);

            $order->orderItems()->saveMany($orders);

            if ($user->user_type === 0) {
                $user->update([
                    'user_type' => UserType::MEMBER['value']
                ]);
            }
        });
    }
}
