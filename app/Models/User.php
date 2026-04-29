<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'phone',
        'nim_nip',
        'gender',
        'birth_date',
        'address',
        'photo',
        'department_id',
        'study_program_id',
        'is_active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    // 🔗 RELASI

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

    // 🔥 HELPER

    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    public function isPetugas()
    {
        return $this->role->name === 'petugas';
    }

    public function isMahasiswa()
    {
        return $this->role->name === 'mahasiswa';
    }
}