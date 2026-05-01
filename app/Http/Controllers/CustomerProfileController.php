<?php

namespace App\Http\Controllers;

use App\Enum\BloodGroup;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerProfileController extends Controller
{
    public function index(): View
    {
        return view('customer.profile.index', [
            'user' => Auth::user()
        ]);
    }

    public function edit(): View
    {
        return view('customer.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $userService = new UserService();
        if ($userService->updateUser(Auth::user(), $request)) {

            flash('Profile updated successfully', 'success');
            return back();
        }

        // else return back with error
        flash('Something went wrong! Unable to update', 'error');
        return back();
    }
}
