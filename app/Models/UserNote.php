<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNote extends Model
{
    use HasFactory;

    const MEMBERNOTE = 1;
    const UPCOMINGRENEWALNOTE = 2;
    const EXPIREDPLANNOTE = 3;
    const REMIANINGBALANCE = 4;
    const PERSONALTRAINERNOTES = 5;

    protected $fillable = [
        'note_type',
        'user_id',
        'note',
        'created_by',
        'next_follow_up_date',
    ];

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return dateFormat($value);
            }
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->with(['userProfile']);
    }
    
}
