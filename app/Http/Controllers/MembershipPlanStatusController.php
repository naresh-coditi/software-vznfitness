<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MembershipPlanStatusController extends Controller
{
    public function update(MembershipPlan $plan)
    {
        try {
            if ($plan->status) {
                $plan->update([
                    'status' => MembershipPlan::INACTIVE,
                ]);
            } else {
                $plan->update([
                    'status' => MembershipPlan::ACTIVE,
                ]);
            }

            return back()->with('success', __('Plan Status Updated Successfully!'));
        } catch (\Throwable $th) {
            Log::info($th);
            flash('Unable to change status', 'error');
            return back();
        }
    }
}
