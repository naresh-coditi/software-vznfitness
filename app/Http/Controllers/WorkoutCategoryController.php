<?php

namespace App\Http\Controllers;

use App\Models\WorkoutCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkoutCategoryController extends Controller
{
    public function index()
    {
        return view('admin.workout.categories.index', [
            'categories' => WorkoutCategory::paginate(20),
            'request' => request()
        ]);
    }

    public function create()
    {
        return view('admin.workout.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);
        try {
            WorkoutCategory::create([
                'name' => $request->name,
                'created_by' => Auth::id(),
                'description' => $request->description
            ]);

            flash('Workout category created successfully', 'success');
            return back();
        } catch (\Throwable $th) {
            flash('something went wrong! Unable to create category', 'error');
            Log::error($th->getMessage());
            return back();
        }
    }


    public function edit(WorkoutCategory $category)
    {
        return view('admin.workout.categories.edit', [
            'category' => $category
        ]);
    }

    public function update(WorkoutCategory $category, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);
        try {
            $category->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            flash('Workout category updated successfully', 'success');
            return back();
        } catch (\Throwable $th) {
            flash('something went wrong! Unable to update category', 'error');
            Log::error($th->getMessage());
            return back();
        }
    }

    public function delete(WorkoutCategory $category)
    {
        try {
            $category->delete();
            flash('Workout category deleted successfully', 'success');
            return back();
        } catch (\Throwable $th) {
            flash('Something went wrong! Unable to delete category', 'error');
            Log::error($th->getMessage());
            return back();
        }
    }
}
