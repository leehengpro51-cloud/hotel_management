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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('booking_id'); // Primary Key (PK)
            $table->foreignId('room_id')->constrained('rooms', 'room_id')->onDelete('cascade'); // Foreign Key (FK)
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone');
            $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->unsignedInteger('total_nights')->default(1);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['Confirmed', 'Checked In', 'Checked Out', 'Cancelled'])->default('Confirmed');
            $table->text('special_requests')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
