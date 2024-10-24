<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Alarm extends Model
{
    use HasFactory;

    protected $table = 'alarm';
    protected $guarded = [];
    protected $dates = [
    ];
    protected $casts = [
    ];
    protected $hidden = [
    ];
    protected $visible = [
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function todolist(): BelongsTo
    {
        return $this->belongsTo(TodoList::class);
    }
}
