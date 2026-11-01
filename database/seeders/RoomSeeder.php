<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            // Deluxe Suites (type_id: 1)
            [
                'room_id' => 1,
                'room_number' => '101',
                'type_id' => 1,
                'floor' => 'Floor 1',
                'status' => 'Available',
                'price_per_night' => 185.00,
                'bed_type' => '1 King Bed',
                'description' => 'Corner suite with easy garden access and oversized marble bath.',
            ],
            [
                'room_id' => 2,
                'room_number' => '102',
                'type_id' => 1,
                'floor' => 'Floor 1',
                'status' => 'Occupied',
                'price_per_night' => 185.00,
                'bed_type' => '1 King Bed',
                'description' => 'Spacious room overlooking the courtyard fountain.',
            ],
            [
                'room_id' => 3,
                'room_number' => '201',
                'type_id' => 1,
                'floor' => 'Floor 2',
                'status' => 'Available',
                'price_per_night' => 195.00,
                'bed_type' => '1 King Bed',
                'description' => 'Second floor suite with panoramic sunrise balcony.',
            ],

            // Executive King (type_id: 2)
            [
                'room_id' => 4,
                'room_number' => '202',
                'type_id' => 2,
                'floor' => 'Floor 2',
                'status' => 'Occupied',
                'price_per_night' => 220.00,
                'bed_type' => '1 California King',
                'description' => 'Business suite with Herman Miller chair and dual monitors setup.',
            ],
            [
                'room_id' => 5,
                'room_number' => '301',
                'type_id' => 2,
                'floor' => 'Floor 3',
                'status' => 'Reserved',
                'price_per_night' => 230.00,
                'bed_type' => '1 California King',
                'description' => 'Executive level room with exclusive lounge privileges.',
            ],
            [
                'room_id' => 6,
                'room_number' => '302',
                'type_id' => 2,
                'floor' => 'Floor 3',
                'status' => 'Available',
                'price_per_night' => 220.00,
                'bed_type' => '1 California King',
                'description' => 'Quiet corner room facing West gardens.',
            ],

            // Presidential Ocean Villa (type_id: 3)
            [
                'room_id' => 7,
                'room_number' => 'PH-01',
                'type_id' => 3,
                'floor' => 'Penthouse',
                'status' => 'Occupied',
                'price_per_night' => 550.00,
                'bed_type' => '2 King Beds',
                'description' => 'Flagship penthouse with private rooftop plunge pool and dedicated butler.',
            ],
            [
                'room_id' => 8,
                'room_number' => 'PH-02',
                'type_id' => 3,
                'floor' => 'Penthouse',
                'status' => 'Available',
                'price_per_night' => 580.00,
                'bed_type' => '2 King Beds',
                'description' => 'Ultra luxury terrace suite with private jacuzzi and unobstructed ocean sunset views.',
            ],

            // Superior Twin Room (type_id: 4)
            [
                'room_id' => 9,
                'room_number' => '103',
                'type_id' => 4,
                'floor' => 'Floor 1',
                'status' => 'Available',
                'price_per_night' => 125.00,
                'bed_type' => '2 Twin Beds',
                'description' => 'Twin room close to elevator and fitness club.',
            ],
            [
                'room_id' => 10,
                'room_number' => '104',
                'type_id' => 4,
                'floor' => 'Floor 1',
                'status' => 'Maintenance',
                'price_per_night' => 125.00,
                'bed_type' => '2 Twin Beds',
                'description' => 'Under scheduled AC maintenance and fresh painting.',
            ],
            [
                'room_id' => 11,
                'room_number' => '203',
                'type_id' => 4,
                'floor' => 'Floor 2',
                'status' => 'Occupied',
                'price_per_night' => 130.00,
                'bed_type' => '2 Twin Beds',
                'description' => 'East facing with morning sun and garden view.',
            ],

            // Standard Queen (type_id: 5)
            [
                'room_id' => 12,
                'room_number' => '105',
                'type_id' => 5,
                'floor' => 'Floor 1',
                'status' => 'Available',
                'price_per_night' => 95.00,
                'bed_type' => '1 Queen Bed',
                'description' => 'Clean, soundproof room ideal for solo or couple travelers.',
            ],
            [
                'room_id' => 13,
                'room_number' => '106',
                'type_id' => 5,
                'floor' => 'Floor 1',
                'status' => 'Reserved',
                'price_per_night' => 95.00,
                'bed_type' => '1 Queen Bed',
                'description' => 'Near lobby and express checkout counter.',
            ],
            [
                'room_id' => 14,
                'room_number' => '204',
                'type_id' => 5,
                'floor' => 'Floor 2',
                'status' => 'Available',
                'price_per_night' => 98.00,
                'bed_type' => '1 Queen Bed',
                'description' => 'Cozy second floor bedroom with high thread count linens.',
            ],

            // Family Garden Suite (type_id: 6)
            [
                'room_id' => 15,
                'room_number' => 'G-01',
                'type_id' => 6,
                'floor' => 'Ground Floor',
                'status' => 'Occupied',
                'price_per_night' => 290.00,
                'bed_type' => '1 King + 2 Bunk Beds',
                'description' => 'Spacious family haven with outdoor BBQ patio and direct lawn access.',
            ],
            [
                'room_id' => 16,
                'room_number' => 'G-02',
                'type_id' => 6,
                'floor' => 'Ground Floor',
                'status' => 'Available',
                'price_per_night' => 290.00,
                'bed_type' => '1 King + 2 Bunk Beds',
                'description' => 'Quiet garden family accommodation next to children playground.',
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(['room_id' => $room['room_id']], $room);
        }
    }
}
