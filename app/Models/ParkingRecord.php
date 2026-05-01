<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingRecord extends Model
{
    protected $fillable = [
        'vehicle_id',
        'plate_number',
        'face_photo',
        'entry_time',
        'exit_time',
        'status',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function isParked()
    {
        return $this->status === 'parked';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}