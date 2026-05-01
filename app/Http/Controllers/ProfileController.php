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
        // #region agent log
        file_put_contents(
            base_path('debug-fc005a.log'),
            json_encode([
                'sessionId' => 'fc005a',
                'runId' => 'initial',
                'hypothesisId' => 'H1',
                'location' => 'app/Http/Controllers/ProfileController.php:update',
                'message' => 'Profile update request received',
                'data' => [
                    'has_image' => $request->hasFile('image'),
                    'uploaded_image_name' => $request->file('image') ? $request->file('image')->getClientOriginalName() : null,
                    'uploaded_image_ext' => $request->file('image') ? $request->file('image')->getClientOriginalExtension() : null,
                    'file_keys' => array_keys($request->files->all()),
                ],
                'timestamp' => round(microtime(true) * 1000),
            ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
            FILE_APPEND
        );
        // #endregion
        $userService = new UserService();

        if ($userService->updateUser($request->user(), $request)) {
            // #region agent log
            file_put_contents(
                base_path('debug-fc005a.log'),
                json_encode([
                    'sessionId' => 'fc005a',
                    'runId' => 'initial',
                    'hypothesisId' => 'H4',
                    'location' => 'app/Http/Controllers/ProfileController.php:update',
                    'message' => 'Profile update completed successfully',
                    'data' => [
                        'redirect_route' => Auth::user()->roleName . 'profile.edit',
                    ],
                    'timestamp' => round(microtime(true) * 1000),
                ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
                FILE_APPEND
            );
            // #endregion
            flash('Profile updated succesfully', 'success');
            return Redirect::route(Auth::user()->roleName . 'profile.edit')->with('status', 'profile-updated');
        }

        // #region agent log
        file_put_contents(
            base_path('debug-fc005a.log'),
            json_encode([
                'sessionId' => 'fc005a',
                'runId' => 'initial',
                'hypothesisId' => 'H4',
                'location' => 'app/Http/Controllers/ProfileController.php:update',
                'message' => 'Profile update returned false',
                'data' => [
                    'redirect_route' => Auth::user()->roleName . 'profile.edit',
                ],
                'timestamp' => round(microtime(true) * 1000),
            ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
            FILE_APPEND
        );
        // #endregion
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
