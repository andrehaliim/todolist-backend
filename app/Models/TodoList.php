<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;
    protected $table = 'todolist';
    protected $appends = [];
    protected $guarded = [];
    protected $dates = [
    ];
    protected $casts = [
    ];
    protected $hidden = [
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

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

