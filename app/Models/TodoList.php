<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TodoList extends Model
{
    use HasFactory;
    protected $table = 'todolist';
    protected $appends = ['alarm'];
    protected $guarded = [];
    protected $dates = [
    ];
    protected $casts = [
    ];
    protected $hidden = ['todolist_alarm'];
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

    public function todolist_alarm(): HasMany
    {
        return $this->hasMany(Alarm::class, 'todolist_id', 'id');
    }

    public function getAlarmAttribute()
    {
        return $this->todolist_alarm;
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

