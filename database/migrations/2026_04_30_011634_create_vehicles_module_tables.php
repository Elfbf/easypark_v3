<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | VEHICLE TYPES
        |--------------------------------------------------------------------------
        */

        Schema::create('vehicle_types', function (Blueprint $table) {

            $table->id();

            $table->string('name'); // motor / mobil

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | VEHICLE BRANDS
        |--------------------------------------------------------------------------
        */

        Schema::create('vehicle_brands', function (Blueprint $table) {

            $table->id();

            $table->string('name'); // Honda, Yamaha, dll

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | PARKING AREAS
        |--------------------------------------------------------------------------
        */

        Schema::create('parking_areas', function (Blueprint $table) {

            $table->id();

            $table->string('name'); // Area A / Gedung TI
            $table->string('code')->unique(); // PRA-A / TI-A

            $table->text('description')->nullable();

            // kapasitas total area
            $table->integer('capacity')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | PARKING SLOTS
        |--------------------------------------------------------------------------
        */

        Schema::create('parking_slots', function (Blueprint $table) {

            $table->id();

            $table->foreignId('parking_area_id')
                ->constrained()
                ->cascadeOnDelete();

            // khusus motor / mobil
            $table->foreignId('vehicle_type_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('slot_code'); // A-01

            $table->enum('status', [
                'available',
                'occupied',
                'maintenance'
            ])->default('available');

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // slot unik dalam area
            $table->unique([
                'parking_area_id',
                'slot_code'
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | VEHICLES
        |--------------------------------------------------------------------------
        */

        Schema::create('vehicles', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            // user pemilik kendaraan
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // tipe kendaraan
            $table->foreignId('vehicle_type_id')
                ->constrained()
                ->cascadeOnDelete();

            // brand kendaraan
            $table->foreignId('vehicle_brand_id')
                ->constrained()
                ->cascadeOnDelete();

            // slot parkir aktif
            $table->foreignId('parking_slot_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | DATA KENDARAAN
            |--------------------------------------------------------------------------
            */

            $table->string('plate_number')->unique();

            $table->string('color')->nullable();

            /*
            |--------------------------------------------------------------------------
            | FOTO
            |--------------------------------------------------------------------------
            */

            // foto kendaraan
            $table->string('vehicle_photo')->nullable();

            // foto STNK
            $table->string('stnk_photo')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS PARKIR
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_parked')->default(false);

            $table->timestamp('parked_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')->default(true);

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
    }
};