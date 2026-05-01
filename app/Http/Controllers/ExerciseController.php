<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\WorkoutCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExerciseController extends Controller
{
    public function index()
    {
        return view('admin.workout.exercise.index', [
            'exercises' => Exercise::paginate(20)
        ]);
    }

    public function view(Exercise $exercise) {}

    public function create()
    {
        return view('admin.workout.exercise.create', [
            'categories' => WorkoutCategory::get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category' => 'required|exists:workout_categories,id'
        ]);

        try {
            Exercise::create([
                'name' => $request->name,
                'description' => $request->description,
                'created_by' => Auth::id(),
                'category_id' => $request->category
            ]);

            flash('Exercise created succesfully', 'success');
            return back();
        } catch (\Throwable $th) {
            flash('Something went wrong! Unable to create exercise', 'error');
            Log::error($th->getMessage());
            return back();
        }
    }

    public function edit(Exercise $exercise, Request $request)
    {
        return view('admin.workout.exercise.edit', [
            'exercise' => $exercise,
            'categories' => WorkoutCategory::get()
        ]);
    }

    public function update(Exercise $exercise, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category' => 'required|exists:workout_categories,id'
        ]);

        try {
            $exercise->update([
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category
            ]);

            flash('Exercise updated succesfully', 'success');
            return back();
        } catch (\Throwable $th) {
            flash('Something went wrong! Unable to update exercise', 'error');
            Log::error($th->getMessage());
            return back();
        }
    }

    public function delete(Exercise $exercise) {}
}
