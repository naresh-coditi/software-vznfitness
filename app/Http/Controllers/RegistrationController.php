<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\MembershipPlan;
use App\Providers\RouteServiceProvider;
use App\Services\AddMembershipService;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    private UserService $userService;
    protected AddMembershipService $memberService;

    public function __construct(UserService $userService)
    {
        $this->memberService = new AddMembershipService();
        $this->userService = $userService;
    }

    public function create()
    {
        return view('auth.register', [
            'plans' => MembershipPlan::isActive()->get(),
            'branches' => Branch::get()
        ]);
    }

    public function store(Request $request)
    {
        flash('Maintaince issue', 'error');
        return back();
        $request->validate([
            'first_name' => 'required|max:255|min:0',
            'last_name' => 'nullable|max:255|min:0',
            'phone' => 'required|digits:10|integer',
            'email' => 'nullable|email',
            'gender' => 'required',
            'password' => 'required|same:confirm_password',
        ]);

        $user = $this->userService->createUser($request);

        if ($user) {
            flash('Registration successfull', 'success');
            event(new Registered($user));
            Auth::login($user);
            return redirect(RouteServiceProvider::HOME);
        }

        flash('Unable to register Please try again later', 'error');
        return back();
    }
}
