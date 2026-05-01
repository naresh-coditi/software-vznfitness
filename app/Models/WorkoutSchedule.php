<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutSchedule extends Model
{
    use HasFactory;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;

    protected $fillable = [
        'plan_id',
        'week_number',
        'category_id',
        'day'
    ];

    protected $appends = [
        'week_name'
    ];

    // Attributes
    public function weekName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return 'Week ' . $this->week_number;
            }
        );
    }

    public function day(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                switch ($value) {
                    case 1:
                        return 'monday';
                        break;
                    case 2:
                        return 'tuesday';
                        break;
                    case 3:
                        return 'wednesday';
                        break;
                    case 4:
                        return 'thursday';
                        break;
                    case 5:
                        return 'friday';
                        break;
                    case 6:
                        return 'saturday';
                        break;
                    default:
                        return null;
                        break;
                }
            }
        );
    }

    public function plan()
    {
        return $this->belongsTo(WorkoutPlan::class, 'plan_id')->withDefault();
    }

    public function scheduleExercises()
    {
        return $this->hasMany(ScheduleExercise::class, 'schedule_id');
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'schedule_exercises', 'schedule_id', 'exercise_id');
    }

    public function category()
    {
        return $this->belongsTo(WorkoutCategory::class, 'category_id');
    }
}
