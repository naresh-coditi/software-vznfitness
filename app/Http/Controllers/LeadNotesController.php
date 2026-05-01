<?php

namespace App\Http\Controllers;

use App\Models\LeadNotes;
use App\Models\LeadUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class LeadNotesController extends Controller
{
    public function index(LeadUser $user)
    {
        return view('admin.lead.notes.index', [
            'user' => $user,
            'notes' => LeadNotes::where('lead_id', $user->id)->get()
        ]);
    }

    public function store(LeadUser $user, Request $request)
    {
        $request->validate([
            'note' => 'required'
        ]);

        try {
            LeadNotes::create([
                'lead_id' => $user->id,
                'note' => $request->note,
                'next_follow_up_date' => $request->next_follow_up_date,
                'created_by' => Auth::id()
            ]);

            if ($request->next_follow_up_date) {
                $user->update([
                    'follow_up_date' => $request->next_follow_up_date,
                    'approach_status' => LeadUser::Pending,
                ]);
            }

            flash('Note added successfully', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong, Unable to add note', 'error');
            return back();
        }
    }

    public function delete(LeadNotes $note)
    {
        try {
            $note->delete();
            flash('Note deleted successfully', 'success');
            return back();
        } catch (Exception $e) {
            flash('Something went wrong, Unable to delete note', 'error');
            return back();
        }
    }
}
