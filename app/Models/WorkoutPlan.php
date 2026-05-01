<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class WorkoutPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_by'
    ];

    // Realtion
    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'imageable')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->with(['userProfile'])->withDefault();
    }

    public function weekData()
    {
        return $this->hasMany(WorkoutSchedule::class, 'plan_id')->with(['exercises', 'category']);
    }
}
