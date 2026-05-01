<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StaffController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): View
    {
        return view('admin.staff.index', [
            'users' => User::with('userProfile')->isStaff()->filter($request)->paginate(50),
            'request' => $request,
        ]);
    }

    public function create(): View
    {
        return view('admin.staff.create', [
            'roles' => Role::isNotUser()->isNotAdmin()->get(),
            'branches' => Branch::get()
        ]);
    }

    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->createStaff($request);
        if ($user) {
            flash('Staff created successfully.', 'success');
            return to_route(Auth::user()->rolename . 'staff.index');
        }

        // Else return back with error
        flash('Something went wrong! Unable to create', 'error');
        return back();
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $user = $this->userService->updateUser($user, $request);
        if ($user) {
            flash('Staff updated successfully.', 'success');
            return to_route(Auth::user()->rolename . 'staff.index');
        }

        // Else return back with error
        flash('Something went wrong! Unable to create', 'error');
        return back();
    }

    public function edit(User $user): View
    {
        return view('admin.staff.edit', [
            'user' => $user,
            'roles' => Role::isNotUser()->isNotAdmin()->get(),
            'branches' => Branch::get()
        ]);
    }

    public function view(User $user): View
    {
        return view('admin.staff.view', [
            'user' => $user,
        ]);
    }
}
