<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParkingSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_area_id',
        'vehicle_type_id',
        'slot_code',
        'status',
        'is_active',
    ];

    public function parkingArea()
    {
        return $this->belongsTo(ParkingArea::class);
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }
}