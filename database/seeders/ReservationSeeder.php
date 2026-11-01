<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservations = [
            [
                'booking_id' => 1,
                'room_id' => 2, // Room 102
                'guest_name' => 'Kong Sopheak',
                'guest_email' => 'kongsopheak@gmail.com',
                'guest_phone' => '+855 12 345 678',
                'gender' => 'Male',
                'check_in_date' => now()->subDays(2)->format('Y-m-d'),
                'check_out_date' => now()->addDays(2)->format('Y-m-d'),
                'total_nights' => 4,
                'total_amount' => 740.00,
                'status' => 'Checked In',
                'special_requests' => 'Late check-out request at 2:00 PM and airport pickup arranged.',
            ],
            [
                'booking_id' => 2,
                'room_id' => 4, // Room 202
                'guest_name' => 'Ly Chhailin',
                'guest_email' => 'lin@gmail.com',
                'guest_phone' => '+855 98 765 432',
                'gender' => 'Female',
                'check_in_date' => now()->subDays(1)->format('Y-m-d'),
                'check_out_date' => now()->addDays(3)->format('Y-m-d'),
                'total_nights' => 4,
                'total_amount' => 880.00,
                'status' => 'Checked In',
                'special_requests' => 'Non-feather pillows requested, quiet floor preferred.',
            ],
            [
                'booking_id' => 3,
                'room_id' => 5, // Room 301
                'guest_name' => 'Pov Nita',
                'guest_email' => 'povnita@gmail.com',
                'guest_phone' => '+855 77 123 999',
                'gender' => 'Female',
                'check_in_date' => now()->addDays(1)->format('Y-m-d'),
                'check_out_date' => now()->addDays(4)->format('Y-m-d'),
                'total_nights' => 3,
                'total_amount' => 690.00,
                'status' => 'Confirmed',
                'special_requests' => 'Honeymoon anniversary setup with complimentary fruit basket.',
            ],
            [
                'booking_id' => 4,
                'room_id' => 7, // PH-01
                'guest_name' => 'Leng Makara',
                'guest_email' => 'lengmakara@gmail.com',
                'guest_phone' => '+855 16 888 234',
                'gender' => 'Male',
                'check_in_date' => now()->subDays(3)->format('Y-m-d'),
                'check_out_date' => now()->addDays(1)->format('Y-m-d'),
                'total_nights' => 4,
                'total_amount' => 2200.00,
                'status' => 'Checked In',
                'special_requests' => 'VIP Butler service, champagne on ice upon arrival.',
            ],
            [
                'booking_id' => 5,
                'room_id' => 11, // Room 203
                'guest_name' => 'Chan David',
                'guest_email' => 'chandavid@gmail.com',
                'guest_phone' => '+855 10 555 777',
                'gender' => 'Male',
                'check_in_date' => now()->subDays(5)->format('Y-m-d'),
                'check_out_date' => now()->subDays(1)->format('Y-m-d'),
                'total_nights' => 4,
                'total_amount' => 520.00,
                'status' => 'Checked Out',
                'special_requests' => 'Invoice sent to company accounting.',
            ],
            [
                'booking_id' => 6,
                'room_id' => 15, // G-01
                'guest_name' => 'Sokha Rathana',
                'guest_email' => 'sokha.rathana@gmail.com',
                'guest_phone' => '+855 89 444 321',
                'gender' => 'Female',
                'check_in_date' => now()->subDays(1)->format('Y-m-d'),
                'check_out_date' => now()->addDays(4)->format('Y-m-d'),
                'total_nights' => 5,
                'total_amount' => 1450.00,
                'status' => 'Checked In',
                'special_requests' => 'Extra baby crib and high chair in room.',
            ],
            [
                'booking_id' => 7,
                'room_id' => 13, // Room 106
                'guest_name' => 'Vannak Borey',
                'guest_email' => 'vannak.borey@gmail.com',
                'guest_phone' => '+855 93 222 111',
                'gender' => 'Male',
                'check_in_date' => now()->addDays(2)->format('Y-m-d'),
                'check_out_date' => now()->addDays(5)->format('Y-m-d'),
                'total_nights' => 3,
                'total_amount' => 285.00,
                'status' => 'Confirmed',
                'special_requests' => 'Early morning check-in requested if available.',
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::updateOrCreate(['booking_id' => $reservation['booking_id']], $reservation);
        }
    }
}
