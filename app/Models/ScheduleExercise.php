<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'exercise_id',
    ];

    // relations
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id')->withDefault();
    }

    public function schedule()
    {
        return $this->belongsTo(WorkoutSchedule::class, 'schedule_id')->withDefault();
    }
}
