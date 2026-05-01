<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        // relation
        'role_id',
        'department_id',
        'study_program_id',

        // basic info
        'name',
        'email',
        'phone',
        'nim_nip',

        // biodata
        'gender',
        'birth_date',
        'address',

        // profile
        'photo',

        // 🔥 face recognition
        'face_photo',
        'face_embedding',

        // status
        'is_active',
        'last_login_at', // ✅ tambahkan ini

        // auth
        'password',
    ];

    /*
    |--------------------------------------------------------------------------
    | HIDDEN
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'password',
        'remember_token',
        'face_embedding', // 🔥 jangan expose embedding AI
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // 🔗 Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // 🔗 Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // 🔗 Study Program
    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    // 🔗 Vehicles
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    // 🔗 Parking Transactions
    public function parkingTransactions()
    {
        return $this->hasMany(ParkingTransaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | FACE RECOGNITION HELPERS
    |--------------------------------------------------------------------------
    */

    // cek apakah user punya data wajah
    public function hasFaceData()
    {
        return !empty($this->face_embedding);
    }

    // cek apakah user punya kendaraan
    public function hasVehicle()
    {
        return $this->vehicles()->exists();
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
