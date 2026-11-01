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
        // Default Angkor Hotel Manager & Admin Account
        User::updateOrCreate(
            ['email' => 'Lyheng@gmail.com'],
            [
                'name' => 'Lyheng',
                'password' => Hash::make('lyheng123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
