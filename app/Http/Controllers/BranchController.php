<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBranchRequest;
use App\Models\Branch;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function index(): View
    {
        return view('admin.branch.index', [
            'branches' => Branch::paginate(50),
        ]);
    }

    public function create(): View
    {
        return view('admin.branch.create');
    }

    public function store(CreateBranchRequest $request): RedirectResponse
    {
        try {
            Branch::create([
                'name' => $request->name,
                'location' => $request->location,
                'address' => $request->address,
                'gst_no' => $request->gst,
                'phone' => $request->phone,
                'open_at' => $request->open_at
            ]);

            flash('Branch created successfully.', 'success');
            return to_route(Auth::user()->rolename . 'branch.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to create branch', 'error');
            return back();
        }
    }

    public function edit(Branch $branch): View
    {
        return view('admin.branch.edit', [
            'branch' => $branch,
        ]);
    }

    public function update(Branch $branch, Request $request): RedirectResponse
    {
        try {
            $branch->update([
                'name' => $request->name,
                'location' => $request->location,
                'address' => $request->address,
                'gst_no' => $request->gst,
                'phone' => $request->phone,
                'open_at' => $request->open_at
            ]);

            flash('Branch updated successfully.', 'success');
            return to_route(Auth::user()->rolename . 'branch.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to update branch', 'error');
            return back();
        }
    }

    public function delete(Branch $branch): RedirectResponse
    {
        try {
            $branch->delete();

            flash('Branch deleted successfully', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to delete branch', 'error');
            return back();
        }
    }
}
