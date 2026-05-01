<?php

namespace App\Http\Controllers;

use App\Enum\UserType;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeletedMemberController extends Controller
{
    public function index()
    {
        return view('admin.deletedMembers.index', [
            'users' => User::with('userProfile', 'membershipDetails', 'createdBy', 'personalTrainer', 'memberNotes')
                ->isUser()
                ->filter(request())
                ->orderBy('id', 'desc')
                ->onlyTrashed()
                ->paginate(50),
            'user_types' => UserType::getUserType(),
            'request' => request(),
        ]);
    }

    public function update(Request $request)
    {
        try {
            $user = User::where('id', $request->user)->onlyTrashed()->first();
            $profile=UserProfile::where('user_id',$request->user)->onlyTrashed()->first();
            if ($user) {
                $user->restore();
                $profile->restore();
            }

            flash('Member restored successfully', 'success');
            return back();
        } catch (\Throwable $th) {
            Log::error($th);
            flash('Unable to restore the member', 'error');
            return back();
        }
    }
}
