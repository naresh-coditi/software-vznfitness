<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewPasswordJob;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ForgotPassword extends Controller
{
    public function edit(User $user): View
    {
        return view('admin.user.forgot_password', [
            'user' => $user
        ]);
    }

    public function update(User $user, Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        try {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            flash('Password updated', 'success');
            return to_route(Auth::user()->roleName . 'user.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to change password', 'error');
            return back();
        }
    }

    public function sendNewPassword(User $user)
    {
        try {
            $password = generatePassword();
            dispatch(new SendNewPasswordJob($user, $password));

            $user->update([
                'password' => Hash::make($password)
            ]);

            flash('New Password sent', 'success');
            return to_route(Auth::user()->roleName . 'user.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to change password', 'error');
            return back();
        }
    }
}
