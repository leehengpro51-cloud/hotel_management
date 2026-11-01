<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $primaryKey = 'room_id';

    protected $fillable = [
        'room_number',
        'type_id',
        'floor',
        'status',
        'price_per_night',
        'bed_type',
        'description',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
    ];

    /**
     * Get the room type category that this room belongs to.
     */
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'type_id', 'type_id');
    }

    /**
     * Alias for relationship matching table name
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'type_id', 'type_id');
    }

    /**
     * Get all reservations for this room.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'room_id', 'room_id');
    }
}
