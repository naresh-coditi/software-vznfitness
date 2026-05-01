<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'location',
        'address',
        'status',
        'gst_no',
        'phone',
        'open_at',
    ];

    protected $casting = [
        'created_at' => 'datetime:d-M-Y',
    ];
}
