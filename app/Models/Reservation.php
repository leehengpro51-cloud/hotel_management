<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'room_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'gender',
        'check_in_date',
        'check_out_date',
        'total_nights',
        'total_amount',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_nights' => 'integer',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the room booked for this reservation.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
}
