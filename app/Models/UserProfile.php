<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "user_profiles";
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'gender',
        'user_type',
        'address',
        'created_by',
        'updated_by',
        'experience',
    ];

    protected $casting = [
        'created_at' => 'datetime:d-M-Y',
    ];

    /** Attributes */

    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? ucfirst($value) : null,
            set: fn($value) => $value ? strtolower($value) : null,
        );
    }

    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? ucfirst($value) : null,
            set: fn($value) => $value ? strtolower($value) : null,
        );
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->first_name . ' ' . $this->last_name;
            }
        );
    }

    protected function gender(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? ucfirst($value) : null,
            set: fn($value) => $value ? strtolower($value) : null,
        );
    }

    public function createdByName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->createdBy->userProfile->fullName ?? '';
            }
        );
    }

    public function updatedByName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->updatedBy->userProfile->fullName;
            }
        );
    }
    /** Relations */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    // public function assignedBy(){
    //     return $this->belongsTo(User::class,'assigned_by')->withDefault();
    // }

    public function scopeFilterUserProfile($query, $search)
    {
        return $query->where('first_name', 'LIKE', '%' . $search . '%')
            ->orWhere('last_name', 'LIKE', '%' . $search . '%');
    }
}
