<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerLoginController extends Controller
{
    public function index()
    {
        return view('customer.auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric'
        ], [
            'phone' => 'The phone number field is required'
        ]);

        try {
            $user = User::where('phone', $request->phone)->where('role_id', User::User)->first();
            if ($user) {
                Auth::login($user);
                return to_route('user.dashboard');
            } else {
                flash('Member not found', 'info');
                return to_route('user.login');
            }
        } catch (\Throwable $th) {
            flash('Something went wrong Unable to login', 'error');
            Log::error($th->getMessage());
            return back();
        }
    }
}
