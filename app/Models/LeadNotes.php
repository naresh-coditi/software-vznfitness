<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadNotes extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'note',
        'created_by',
        'next_follow_up_date'
    ];


    public function nextFollowUpDate(): Attribute
    {
        return Attribute::make(get: function ($value) {
            return dateFormat($value);
        });
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(get: function ($value) {
            return dateFormat($value);
        });
    }

    public function leadDetails()
    {
        return $this->belongsTo(LeadUser::class, 'lead_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->with('userProfile')->withDefault();
    }
}
