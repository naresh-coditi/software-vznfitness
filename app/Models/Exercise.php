<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'created_by'
    ];

    public function name(): Attribute
    {
        return Attribute::make(
            get: function ($val) {
                return ucfirst($val);
            }
        );
    }

    // Relations
    public function images()
    {
        return $this->morphMany(Media::class, 'imageable');
    }

    public function category()
    {
        return $this->belongsTo(WorkoutCategory::class, 'category_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function scheduleExercises()
    {
        return $this->hasMany(ScheduleExercise::class, 'exercise_id');
    }
}
