<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class CustomerWorkoutController extends Controller
{
    public function index()
    {
        return view('customer.workouts.index', [
            'plans' => WorkoutPlan::latest()->get(),
        ]);
    }

    public function view(WorkoutPlan $plan)
    {
        return view('customer.workouts.view', [
            'plan' => $plan,
            'weeks' => $plan->weekData->groupBy('week_number')
        ]);
    }
}
