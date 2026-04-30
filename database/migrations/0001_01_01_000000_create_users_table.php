<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ROLES
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // DEPARTMENTS (JURUSAN)
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // contoh: Teknologi Informasi
            $table->timestamps();
        });

        // STUDY PROGRAMS (PRODI)
        Schema::create('study_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // contoh: Teknik Informatika
            $table->timestamps();
        });

        // USERS
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('nim_nip')->nullable()->unique();

            // Biodata
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();

            // Foto wajah utama
            $table->string('face_photo')->nullable();

            // Vector AI embedding
            $table->longText('face_embedding')->nullable();

            // Relasi kampus
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('study_program_id')->nullable()->constrained()->nullOnDelete();

            // Status
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
        });

        // PASSWORD RESET
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // SESSIONS
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // PASSWORD RESET OTP
        Schema::create('password_reset_otps', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('otp', 6);
            $table->timestamp('expired_at');
            $table->boolean('is_used')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('study_programs');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('password_reset_otps');
    }
};
