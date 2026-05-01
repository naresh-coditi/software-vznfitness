<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserNoteController extends Controller
{
    public function store(User $user, Request $request)
    {
        $request->validate([
            'note' => 'required'
        ]);

        try {
            UserNote::create([
                'user_id' => $user->id,
                'note' => $request->note,
                'note_type' => $request->type,
                'created_by' => Auth::id(),
                'next_follow_up_date' => $request->next_follow_up_date,
            ]);

            flash('Note added successfully', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong, Unable to add note', 'error');
            return back();
        }
    }

    public function delete(UserNote $note)
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
