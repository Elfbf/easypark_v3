<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'module',
        'activity',
        'description',
        'ip_address',
        'user_agent',
        'url',
        'method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}