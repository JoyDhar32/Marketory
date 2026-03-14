<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Primary admin
        User::updateOrCreate(
            ['email' => 'admin@marketory.com'],
            [
                'name'               => 'Admin',
                'password'           => Hash::make('password'),
                'is_admin'           => true,
                'email_verified_at'  => now(),
            ]
        );

        // Owner admin
        User::updateOrCreate(
            ['email' => 'joynsw100@gmail.com'],
            [
                'name'               => 'Joy',
                'password'           => Hash::make('joynsw100@gmail.com'),
                'is_admin'           => true,
                'email_verified_at'  => now(),
            ]
        );
    }
}
