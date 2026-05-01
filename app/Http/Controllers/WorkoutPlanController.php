<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\WorkoutCategory;
use App\Models\WorkoutPlan;
use App\Models\WorkoutSchedule;
use App\Services\WorkoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkoutPlanController extends Controller
{
    public function __construct(private WorkoutService $workoutService) {}

    public function index()
    {
        return view('admin.workout.plans.index', [
            'plans' => WorkoutPlan::with('createdBy')->latest()->paginate(20),
            'request' => request()
        ]);
    }

    public function create()
    {
        return view('admin.workout.plans.create', [
            'categories' => WorkoutCategory::get(),
            'exercises' => Exercise::get()
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'weekData' => 'array|required'
        ], [
            'weekData.required' => 'Please insert at least one plan'
        ]);

        $status = $this->workoutService->storeWorkoutPlan($request);
        if ($status) {
            flash('Workout plan created successfully', 'success');
            return back();
        }

        flash('Somrthing went wrong! Unable to add plan', 'error');
        return back();
    }

    public function view(WorkoutPlan $plan)
    {
        $plan->load('weekData');
        return view('admin.workout.plans.view', [
            'plan' => $plan,
            'weeks' => $plan->weekData->groupBy('week_number')
        ]);
    }

    public function edit(WorkoutPlan $plan)
    {
        return view('admin.workout.plans.edit', [
            'plan' => $plan->load('weekData'),
            'categories' => WorkoutCategory::get(),
            'exercises' => Exercise::get()
        ]);
    }

    public function update(WorkoutPlan $plan, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'weekData' => 'array|required'
        ], [
            'weekData.required' => 'Please insert at least one plan'
        ]);

        $status = $this->workoutService->updateWorkoutPlan($request, $plan);
        if ($status) {
            flash('Workout plan updated successfully', 'success');
            return back();
        }

        flash('Somrthing went wrong! Unable to update plan', 'error');
        return back();
    }

    public function delete(WorkoutPlan $plan)
    {
        try {
            $plan->delete();
            flash('Workout plan deleted successfully', 'success');
            return back();
        } catch (\Throwable $th) {
            flash('Somrthing went wrong! Unable to delete plan', 'error');
            Log::error($th->getMessage());
            return back();
        }
    }
}
