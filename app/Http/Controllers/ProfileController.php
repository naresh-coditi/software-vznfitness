<?php

namespace App\Http\Controllers;

use App\Enum\BloodGroup;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(), 
            'blood_groups' => BloodGroup::getBloodGroups(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $userService = new UserService();

        if ($userService->updateUser($request->user(), $request)) {
            flash('Profile updated succesfully', 'success');
            return Redirect::route(Auth::user()->roleName . 'profile.edit')->with('status', 'profile-updated');
        }

        flash('Unable to update profile', 'error');
        return Redirect::route(Auth::user()->roleName . 'profile.edit');
        // $request->user()->save();

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
