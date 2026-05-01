<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_type_id',
        'vehicle_brand_id',
        'vehicle_model_id',
        'parking_slot_id',
        'plate_number',
        'color',
        'vehicle_photo',
        'stnk_photo',
        'is_parked',
        'parked_at',
        'is_active',
    ];

    protected $casts = [
        'is_parked' => 'boolean',
        'is_active' => 'boolean',
        'parked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function brand()
    {
        return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
    }

    public function model()
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }

    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class);
    }
}