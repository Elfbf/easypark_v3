<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('vehicle_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('parking_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->integer('capacity')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('parking_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_area_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_type_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slot_code');
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['parking_area_id', 'slot_code']);
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vehicle_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parking_slot_id')->nullable()->constrained()->nullOnDelete();

            $table->string('plate_number')->unique();
            $table->string('color')->nullable();

            $table->string('vehicle_photo')->nullable();
            $table->string('stnk_photo')->nullable();

            $table->boolean('is_parked')->default(false);
            $table->timestamp('parked_at')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        Schema::create('parking_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();

            $table->string('plate_number');
            $table->string('face_photo')->nullable();

            $table->timestamp('entry_time');
            $table->timestamp('exit_time')->nullable();

            $table->enum('status', ['parked', 'completed'])->default('parked');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('parking_slots');
        Schema::dropIfExists('parking_areas');
        Schema::dropIfExists('vehicle_brands');
        Schema::dropIfExists('vehicle_types');
        Schema::dropIfExists('parking_records');
    }
};
