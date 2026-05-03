<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'department_id',
        'study_program_id',
        'name',
        'email',
        'phone',
        'nim_nip',
        'gender',
        'birth_date',
        'address',
        'photo',
        'face_photo',
        'face_embedding',
        'is_active',
        'last_login_at',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'face_embedding',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function parkingTransactions()
    {
        return $this->hasMany(ParkingRecord::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isAdmin()
    {
        return $this->role?->name === 'admin';
    }

    public function isPetugas()
    {
        return $this->role?->name === 'petugas';
    }

    public function isMahasiswa()
    {
        return $this->role?->name === 'mahasiswa';
    }

    public function hasFaceData()
    {
        return !empty($this->face_embedding);
    }

    public function hasVehicle()
    {
        return $this->vehicles()->exists();
    }
}