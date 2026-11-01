<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('room_id'); // Primary Key (PK)
            $table->string('room_number')->unique();
            $table->foreignId('type_id')->constrained('room_types', 'type_id')->onDelete('cascade'); // Foreign Key (FK)
            $table->string('floor')->default('Floor 1');
            $table->enum('status', ['Available', 'Occupied', 'Reserved', 'Maintenance'])->default('Available');
            $table->decimal('price_per_night', 10, 2);
            $table->string('bed_type')->default('1 King Bed');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
