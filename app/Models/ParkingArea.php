<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParkingArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'capacity',
        'is_active',
    ];

}