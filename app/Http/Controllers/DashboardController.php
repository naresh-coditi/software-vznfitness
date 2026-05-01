<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(): RedirectResponse
    {
        if (!empty(Auth::user())) {
            // if (Auth::user()->roleName == 'staff.') {
            //     return to_route('staff.user.index')->with(['openFollowUpModal' => true]);
            // }
            return to_route(Auth::user()->roleName . 'dashboard')->with(['openFollowUpModal' => true]);
        }

        return to_route('login');
    }
}
