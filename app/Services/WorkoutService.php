<?php


namespace App\Services;

use App\Models\WorkoutPlan;
use App\Models\WorkoutSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkoutService
{
    public function storeWorkoutPlan(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $plan = WorkoutPlan::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'created_by' => Auth::id()
                ]);

                $weeks = $request->weekData;
                foreach ($weeks as $key => $week) {
                    if (@$week['monday'] ?? null) {
                        $monday = WorkoutSchedule::create([
                            'plan_id' => $plan->id,
                            'week_number' => $key + 1,
                            'day' => WorkoutSchedule::MONDAY,
                            'category_id' => $week['monday']['id']
                        ]);
                        if (@$week['monday']['exercises']) {
                            $monday->exercises()->attach($week['monday']['exercises']);
                        }
                    }
                    if (@$week['tuesday'] ?? null) {
                        $tuesday = WorkoutSchedule::create([
                            'plan_id' => $plan->id,
                            'week_number' => $key + 1,
                            'day' => WorkoutSchedule::TUESDAY,
                            'category_id' => $week['tuesday']['id']
                        ]);

                        if (@$week['tuesday']['exercises']) {
                            $tuesday->exercises()->attach($week['tuesday']['exercises']);
                        }
                    }
                    if (@$week['wednesday'] ?? null) {
                        $wednesday = WorkoutSchedule::create([
                            'plan_id' => $plan->id,
                            'week_number' => $key + 1,
                            'day' => WorkoutSchedule::WEDNESDAY,
                            'category_id' => $week['wednesday']['id']
                        ]);

                        if (@$week['wednesday']['exercises']) {
                            $wednesday->exercises()->attach($week['wednesday']['exercises']);
                        }
                    }
                    if (@$week['thursday'] ?? null) {
                        $thursday = WorkoutSchedule::create([
                            'plan_id' => $plan->id,
                            'week_number' => $key + 1,
                            'day' => WorkoutSchedule::THURSDAY,
                            'category_id' => $week['thursday']['id']
                        ]);


                        if (@$week['thursday']['exercises']) {
                            $thursday->exercises()->attach($week['thursday']['exercises']);
                        }
                    }
                    if (@$week['friday'] ?? null) {
                        $friday = WorkoutSchedule::create([
                            'plan_id' => $plan->id,
                            'week_number' => $key + 1,
                            'day' => WorkoutSchedule::FRIDAY,
                            'category_id' => $week['friday']['id']
                        ]);

                        if (@$week['friday']['exercises']) {
                            $friday->exercises()->attach($week['friday']['exercises']);
                        }
                    }
                    if (@$week['saturday'] ?? null) {
                        $saturday = WorkoutSchedule::create([
                            'plan_id' => $plan->id,
                            'week_number' => $key + 1,
                            'day' => WorkoutSchedule::SATURDAY,
                            'category_id' => $week['saturday']['id']
                        ]);

                        if (@$week['saturday']['exercises']) {
                            $saturday->exercises()->attach($week['saturday']['exercises']);
                        }
                    }
                }
            });

            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return false;
        }
    }

    public function updateWorkoutPlan(Request $request, WorkoutPlan $plan)
    {
        try {
            DB::transaction(function () use ($request, $plan) {
                $plan->update([
                    'name' => $request->name,
                    'description' => $request->description
                ]);

                $weekData = $request->weekData;
                foreach ($weekData as $key => $week) {
                    if ($week['monday'] ?? null) {
                        $monday = WorkoutSchedule::updateOrCreate(['id' => $week['monday']['id'] ?? null], [
                            'plan_id' => $plan->id,
                            'day' => WorkoutSchedule::MONDAY,
                            'week_number' => $key + 1,
                            'category_id' => $week['monday']['category_id']
                        ]);

                        if (@$week['monday']['exercises']) {
                            $existingExercises = $monday->exercises()->pluck('exercises.id')->toArray();
                            $newExercises = $week['monday']['exercises'];
                            $exercisesToDetach = array_diff($existingExercises, $newExercises);
                            $exercisesToAttach = array_diff($newExercises, $existingExercises);
                            if (!empty($exercisesToDetach)) {
                                $monday->exercises()->detach($exercisesToDetach);
                            }

                            if (!empty($exercisesToAttach)) {
                                $monday->exercises()->attach($exercisesToAttach);
                            }
                        } else {
                            $monday->exercises()->detach();
                        }
                    }
                    if ($week['tuesday'] ?? null) {
                        $tuesday = WorkoutSchedule::updateOrCreate(['id' => $week['tuesday']['id'] ?? null], [
                            'plan_id' => $plan->id,
                            'day' => WorkoutSchedule::TUESDAY,
                            'week_number' => $key + 1,
                            'category_id' => $week['tuesday']['category_id']
                        ]);

                        if (@$week['tuesday']['exercises']) {
                            $existingExercises = $tuesday->exercises()->pluck('exercises.id')->toArray();
                            $newExercises = $week['tuesday']['exercises'];
                            $exercisesToDetach = array_diff($existingExercises, $newExercises);
                            $exercisesToAttach = array_diff($newExercises, $existingExercises);
                            if (!empty($exercisesToDetach)) {
                                $tuesday->exercises()->detach($exercisesToDetach);
                            }

                            if (!empty($exercisesToAttach)) {
                                $tuesday->exercises()->attach($exercisesToAttach);
                            }
                        } else {
                            $tuesday->exercises()->detach();
                        }
                    }
                    if ($week['wednesday'] ?? null) {
                        $wednesday = WorkoutSchedule::updateOrCreate(['id' => $week['wednesday']['id'] ?? null], [
                            'plan_id' => $plan->id,
                            'day' => WorkoutSchedule::WEDNESDAY,
                            'week_number' => $key + 1,
                            'category_id' => $week['wednesday']['category_id']
                        ]);

                        if (@$week['wednesday']['exercises']) {
                            $existingExercises = $wednesday->exercises()->pluck('exercises.id')->toArray();
                            $newExercises = $week['wednesday']['exercises'];
                            $exercisesToDetach = array_diff($existingExercises, $newExercises);
                            $exercisesToAttach = array_diff($newExercises, $existingExercises);
                            if (!empty($exercisesToDetach)) {
                                $wednesday->exercises()->detach($exercisesToDetach);
                            }

                            if (!empty($exercisesToAttach)) {
                                $wednesday->exercises()->attach($exercisesToAttach);
                            }
                        } else {
                            $wednesday->exercises()->detach();
                        }
                    }
                    if ($week['thursday'] ?? null) {
                        $thursday = WorkoutSchedule::updateOrCreate(['id' => $week['thursday']['id'] ?? null], [
                            'plan_id' => $plan->id,
                            'day' => WorkoutSchedule::THURSDAY,
                            'week_number' => $key + 1,
                            'category_id' => $week['thursday']['category_id']
                        ]);

                        if (@$week['thursday']['exercises']) {
                            $existingExercises = $thursday->exercises()->pluck('exercises.id')->toArray();
                            $newExercises = $week['thursday']['exercises'];
                            $exercisesToDetach = array_diff($existingExercises, $newExercises);
                            $exercisesToAttach = array_diff($newExercises, $existingExercises);
                            if (!empty($exercisesToDetach)) {
                                $thursday->exercises()->detach($exercisesToDetach);
                            }

                            if (!empty($exercisesToAttach)) {
                                $thursday->exercises()->attach($exercisesToAttach);
                            }
                        } else {
                            $thursday->exercises()->detach();
                        }
                    }
                    if ($week['friday'] ?? null) {
                        $friday = WorkoutSchedule::updateOrCreate(['id' => $week['friday']['id'] ?? null], [
                            'plan_id' => $plan->id,
                            'day' => WorkoutSchedule::FRIDAY,
                            'week_number' => $key + 1,
                            'category_id' => $week['friday']['category_id']
                        ]);

                        if (@$week['friday']['exercises']) {
                            $existingExercises = $friday->exercises()->pluck('exercises.id')->toArray();
                            $newExercises = $week['friday']['exercises'];
                            $exercisesToDetach = array_diff($existingExercises, $newExercises);
                            $exercisesToAttach = array_diff($newExercises, $existingExercises);
                            if (!empty($exercisesToDetach)) {
                                $friday->exercises()->detach($exercisesToDetach);
                            }

                            if (!empty($exercisesToAttach)) {
                                $friday->exercises()->attach($exercisesToAttach);
                            }
                        } else {
                            $friday->exercises()->detach();
                        }
                    }
                    if ($week['saturday'] ?? null) {
                        $saturday = WorkoutSchedule::updateOrCreate(['id' => $week['saturday']['id'] ?? null], [
                            'plan_id' => $plan->id,
                            'day' => WorkoutSchedule::SATURDAY,
                            'week_number' => $key + 1,
                            'category_id' => $week['saturday']['category_id']
                        ]);

                        if (@$week['saturday']['exercises']) {
                            $existingExercises = $saturday->exercises()->pluck('exercises.id')->toArray();
                            $newExercises = $week['saturday']['exercises'];
                            $exercisesToDetach = array_diff($existingExercises, $newExercises);
                            $exercisesToAttach = array_diff($newExercises, $existingExercises);
                            if (!empty($exercisesToDetach)) {
                                $saturday->exercises()->detach($exercisesToDetach);
                            }

                            if (!empty($exercisesToAttach)) {
                                $saturday->exercises()->attach($exercisesToAttach);
                            }
                        } else {
                            $saturday->exercises()->detach();
                        }
                    }
                }
            });

            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return false;
        }
    }
}
