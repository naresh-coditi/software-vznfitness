<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Import Carbon for date handling

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id',
        'phone',
        'timing',
    ];
    protected $table = "attendance";

    const Morning = 'Morning';
    const Evening = 'Evening';

    //Scope functions
    public function scopeFilter($query)
    {
        if ($date = request('date')) {
            $query->whereDate('created_at', $date);
        }
        if (request('search')) {
            $query->whereHas('user.userProfile', function ($q) {
                $q->where('first_name', 'like', '%' . request('search') . '%')
                  ->orWhere('last_name', 'like', '%' . request('search') . '%');
            })->orWhereHas('user', function($q){
                $q->where('member_id', 'like', '%' . request('search') . '%');
            });
        }
    }
    //Relationships
    public function user()
    {
        return $this->belongsTo(user::class, 'member_id')->withDefault();
    }
}
