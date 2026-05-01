<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MembershipPlan extends Model
{
    use HasFactory;

    const INACTIVE = 0;
    const ACTIVE = 1;

    protected $fillable = [
        'name',
        'cost',
        'validity',
        'status',
        'created_by',
        'updated_by',
        'status'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'membership_type'
    ];

    // scopes
    public function scopeIsActive($query)
    {
        $query->where('status', MembershipPlan::ACTIVE);
    }
    // Attributes
    public function membershipType(): Attribute
    {
        return Attribute::make(function () {
            return implode(' + ', collect($this->categories->pluck('name')->toArray())->unique()->toArray());
        });
    }

    // Relations
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(MembershipCategory::class, 'membership_plan_categories', 'membership_id', 'category_id');
    }

    public function createdByProfile()
    {
        return $this->hasOneThrough(UserProfile::class, User::class, 'id', 'user_id', 'created_by', 'id')->withDefault();
    }

    public function updatedByProfile()
    {
        return $this->hasOneThrough(UserProfile::class, User::class, 'id', 'user_id', 'updated_by', 'id')->withDefault();
    }
}
