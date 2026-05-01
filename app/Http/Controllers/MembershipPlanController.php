<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipPlanReqest;
use App\Models\MembershipPlan;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class MembershipPlanController extends Controller
{
    public function index(): View
    {
        return view('admin.membership.plan.index', [
            'plans' => MembershipPlan::with('createdByProfile', 'updatedByProfile')->orderBy('id', 'desc')->paginate(50),
        ]);
    }

    public function create(): View
    {
        return view('admin.membership.plan.create');
    }

    public function store(MembershipPlanReqest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                MembershipPlan::create([
                    'name' => $request->name,
                    'cost' => $request->cost,
                    'validity' => $request->validity,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id()
                ]);
            });

            flash('Plan created succesfull.', 'success');
            return to_route(Auth::user()->roleName . 'membershipplan.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to create Plan.', 'error');
            return back();
        }
    }

    public function edit(MembershipPlan $plan): View
    {
        return view('admin.membership.plan.edit', [
            'plan' => $plan
        ]);
    }

    public function update(MembershipPlan $plan, MembershipPlanReqest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($plan, $request) {
                $plan->update([
                    'name' => $request->name,
                    'cost' => $request->cost,
                    'validity' => $request->validity,
                    'updated_by' => Auth::id()
                ]);
            });

            flash('Plan Updated succesfull.', 'success');
            return to_route(Auth::user()->roleName . 'membershipplan.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to update Plan.', 'error');
            return back();
        }
    }

    public function delete(MembershipPlan $plan): RedirectResponse
    {
        try {
            $plan->delete();
            flash('Plan deleted', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to delete plan', 'error');
            return back();
        }
    }
}
