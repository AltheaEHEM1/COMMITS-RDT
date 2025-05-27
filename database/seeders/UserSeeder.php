<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'first_name' => 'Standard',
            'last_name' => 'User',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('standard123'),
            'role' => 'standard',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}