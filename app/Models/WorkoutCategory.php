<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_at',
        'created_by',
    ];

    // attributes

    public function name(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return ucfirst($value) ?? 'Rest and Recover';
            }
        );
    }

    // Relations
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->with(['userProfile'])->withDefault();
    }
}
