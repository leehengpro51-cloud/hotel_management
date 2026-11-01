<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    use HasFactory;

    protected $table = 'room_types';
    protected $primaryKey = 'type_id';

    protected $fillable = [
        'type_name',
        'manager_id',
        'location_id',
        'base_price',
        'capacity',
        'description',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'capacity' => 'integer',
    ];

    /**
     * Get all rooms belonging to this room type.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'type_id', 'type_id');
    }
}
