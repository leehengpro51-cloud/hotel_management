<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Account 1 (Angkor Hotel Manager)
        User::firstOrCreate(
            ['email' => 'admin@angkorhotel.com'],
            [
                'name' => 'Angkor General Manager',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name' => 'General Manager',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Admin Account 2 (matches example in PDF slide 4/5)
        User::firstOrCreate(
            ['email' => 'adminwoman@gmail.com'],
            [
                'name' => 'Front Desk Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Account 3 for generic admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Hotel Administrator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
