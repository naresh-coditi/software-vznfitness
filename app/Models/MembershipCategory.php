<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MembershipCategory extends Model
{
    use HasFactory;

    protected $table = "membership_categories";

    protected $fillable = [
        'name',
        'status'
    ];

    // Relations
    public function membershipPlan(): BelongsToMany
    {
        return $this->belongsToMany(MembershipPlan::class, 'membership_plan_categories', 'category_id', 'membership_id');
    }
}
