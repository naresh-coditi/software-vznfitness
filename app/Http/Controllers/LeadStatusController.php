<?php

namespace App\Http\Controllers;

use App\Models\LeadUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeadStatusController extends Controller
{
    public function update(LeadUser $user)
    {
        try {
            if ($user->status) {
                $user->update([
                    'status' => LeadUser::INACTIVE,
                ]);
            } else {
                $user->update([
                    'status' => LeadUser::ACTIVE,
                ]);
            }

            return back()->with('success', __('Lead Status Updated Successfully!'));
        } catch (\Throwable $th) {
            Log::info($th);
            flash('Unable to change status', 'error');
            return back();
        }
    }
}
