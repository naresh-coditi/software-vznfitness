<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('admin.role.index', [
            'roles' => Role::paginate(50),
        ]);
    }

    public function create(): View
    {
        return view('admin.role.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:2|max:255|unique:roles,name'
        ]);

        try {
            Role::create([
                'name' => $request->name
            ]);

            flash('Role created successfully!', 'success');
            return to_route(Auth::user()->rolename . 'role.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to create role', 'error');
            return back();
        }
    }

    public function edit(Role $role): View
    {
        return view('admin.role.edit', [
            'role' => $role,
        ]);
    }

    public function update(Role $role, Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name|min:2|max:255'
        ]);

        try {
            $role->update([
                'name' => $request->name
            ]);

            flash('Role updated succesfully!', 'success');
            return to_route(Auth::user()->rolename . 'role.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to upadte role', 'error');
            return back();
        }
    }

    public function delete(Role $role): RedirectResponse
    {
        try {
            if ($role->id === User::Admin) {
                flash('Unable to delete Admin Role!', 'error');
                return back();
            }

            $role->delete();
            flash('Role deleted successfully!', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to delete role.', 'error');
            return back();
        }
    }
}
