<?php

namespace App\Http\Controllers;

use App\Enum\ApproachStatus;
use App\Models\LeadUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FollowUpLeadController extends Controller
{
    public function index()
    {
        return view('admin.followuplead.index', [
            'users' => LeadUser::with(['createdBy', 'notes', 'createdByProfile'])->filter(request())->followUpLead()->paginate(50),
            'request' => request(),
        ]);
    }
    public function check($id){
        $leadUser=LeadUser::find($id);
        if (!$leadUser) {
            flash('Lead User not found', 'error');
            return back();
        }    
        try {
            $leadUser->update([
            'approach_status'=>'1',
        ]);
        flash('Approach Status Updated', 'success');
        return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to update approach status', 'error');
            return back();
        }
        
    }
}
