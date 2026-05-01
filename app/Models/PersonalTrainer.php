<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalTrainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'trainer',
        'duration',
        'amount',
        'start_date',
        'end_date',
        'method_type',
        'remaining_balance',
        'trainer_id'
    ];

    public function memberDetails()
    {
        return $this->belongsTo(User::class, 'member_id')->withDefault();
    }

    public function memberProfile()
    {
        return $this->hasOneThrough(UserProfile::class, User::class, 'id', 'user_id', 'member_id', 'id')->withDefault();
    }
}
