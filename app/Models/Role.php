<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    const Admin = 1;
    const Staff = 1;
    const User = 3;
    const Trainer = 4;

    protected $table = 'roles';
    protected $fillable = [
        'name',
        'status'
    ];

    /** Sluggable  */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name'],
                'onUpdate' => true
            ]
        ];
    }

    /** Scopes */
    public function scopeIsNotAdmin($query)
    {
        return $query->where('id', '!=', $this::Admin);
    }

    public function scopeIsNotStaff($query)
    {
        return $query->where('id', '!=', $this::Staff);
    }

    public function scopeIsNotUser($query)
    {
        return $query->where('id', '!=', $this::User);
    }

    public function scopeIsUser($query)
    {
        return $query->where('id', $this::User);
    }

    // Attributes
    // protected function name(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => ucfirst($value),
    //         set: fn (string $value) => strtolower($value),
    //     );
    // }

    // Relations
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
}
