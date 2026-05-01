<?php

namespace App\Http\Controllers;

use App\Models\LeadUser;
use App\Models\User;
use Illuminate\Http\Request;

class LeadTransferController extends Controller
{
    public function transfer(User $user, $id)
    {
        $leadUser = LeadUser::find($id);
        if (!$leadUser) {
            return back()->with('error', 'Lead user not found');
        }
        $leadUser->assigned_to = $user->id;
        $leadUser->save();
        return back();
    }
}
