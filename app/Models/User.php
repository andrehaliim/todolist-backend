<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard_name = 'web';
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'is_active',
        'role',
    ];
    protected $appends = [];
    protected $guarded = [];
    protected $dates = [
    ];
    protected $casts = [
        'is_active' => 'integer',
    ];
    protected $hidden = [
        'password',
    ];
    protected $visible = [
    ];
    protected $attributes = [
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($data) {
        });

        self::updating(function ($data) {
        });
    }

    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => empty($value) ? null : $value
        );
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
