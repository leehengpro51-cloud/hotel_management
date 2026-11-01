<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'type_id' => 1,
                'type_name' => 'Deluxe Suite',
                'manager_id' => 'MGR-101 (Michael Vance)',
                'location_id' => 'North Tower - Floors 3-5',
                'base_price' => 185.00,
                'capacity' => 3,
                'description' => 'Spacious suite featuring king-size bedding, private balcony with city skyline views, marble bathroom, and complimentary mini-bar.',
            ],
            [
                'type_id' => 2,
                'type_name' => 'Executive King',
                'manager_id' => 'MGR-102 (Sarah Jenkins)',
                'location_id' => 'West Wing - Floors 4-6',
                'base_price' => 220.00,
                'capacity' => 2,
                'description' => 'Tailored for corporate travelers with ergonomic workspace, high-speed fiber internet, lounge access, and panoramic bay views.',
            ],
            [
                'type_id' => 3,
                'type_name' => 'Presidential Ocean Villa',
                'manager_id' => 'MGR-103 (David Kim)',
                'location_id' => 'Penthouse & Beachfront Pavilion',
                'base_price' => 550.00,
                'capacity' => 4,
                'description' => 'Top-tier luxury penthouse featuring private infinity plunge pool, butler service, 2 master bedrooms, and complete sea vistas.',
            ],
            [
                'type_id' => 4,
                'type_name' => 'Superior Twin Room',
                'manager_id' => 'MGR-104 (Elena Rossi)',
                'location_id' => 'East Wing - Floors 1-3',
                'base_price' => 125.00,
                'capacity' => 2,
                'description' => 'Two plush twin beds, contemporary aesthetic, rain shower, smart streaming LED TV, and espresso machine.',
            ],
            [
                'type_id' => 5,
                'type_name' => 'Standard Queen',
                'manager_id' => 'MGR-105 (Lucas Moreau)',
                'location_id' => 'South Tower - Floors 1-2',
                'base_price' => 95.00,
                'capacity' => 2,
                'description' => 'Cozy modern room with queen bed, ensuite shower, soundproof windows, and essential hospitality conveniences.',
            ],
            [
                'type_id' => 6,
                'type_name' => 'Family Garden Suite',
                'manager_id' => 'MGR-106 (Amina Al-Sayed)',
                'location_id' => 'Garden Wing - Ground Level',
                'base_price' => 290.00,
                'capacity' => 5,
                'description' => 'Two interconnected bedrooms with private garden patio, kids play nook, kitchenette, and direct resort pool access.',
            ],
        ];

        foreach ($types as $type) {
            RoomType::updateOrCreate(['type_id' => $type['type_id']], $type);
        }
    }
}
