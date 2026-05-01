<?php

namespace App\Observers;

use App\Models\LeadUser;
use App\Models\user;
use Exception;
use Illuminate\Support\Facades\Log;

class RemoveClosedLead
{
    /**
     * Handle the user "created" event.
     */
    public function created(user $user): void
    {
        try {
            $lead = LeadUser::where('phone', $user->phone)->first();
            if($lead){
                if($lead->image){
                    $lead->image->delete();
                }
                $lead->delete();
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Handle the user "updated" event.
     */
    public function updated(user $user): void
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     */
    public function deleted(user $user): void
    {
        //
    }

    /**
     * Handle the user "restored" event.
     */
    public function restored(user $user): void
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     */
    public function forceDeleted(user $user): void
    {
        //
    }
}
