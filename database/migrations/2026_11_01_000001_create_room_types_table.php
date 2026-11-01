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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id('type_id'); // Primary Key (PK)
            $table->string('type_name');
            $table->string('manager_id')->nullable(); // Manager in charge (e.g. MGR-101)
            $table->string('location_id')->nullable(); // Hotel Wing / Zone (e.g. North Tower Floors 3-5)
            $table->decimal('base_price', 10, 2)->default(100.00);
            $table->unsignedInteger('capacity')->default(2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
