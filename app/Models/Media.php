<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;
    protected $table = 'media';
    protected $fillable = [
        'path',
        'type',
        'name',
        'size',
        'imageable_type',
        'imageable_id'
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo()->withDefault();
    }
}
