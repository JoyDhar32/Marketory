<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Alice Johnson',  'email' => 'alice@example.com'],
            ['name' => 'Bob Smith',      'email' => 'bob@example.com'],
            ['name' => 'Carol White',    'email' => 'carol@example.com'],
            ['name' => 'David Brown',    'email' => 'david@example.com'],
            ['name' => 'Emma Davis',     'email' => 'emma@example.com'],
            ['name' => 'Frank Miller',   'email' => 'frank@example.com'],
            ['name' => 'Grace Wilson',   'email' => 'grace@example.com'],
            ['name' => 'Henry Moore',    'email' => 'henry@example.com'],
            ['name' => 'Isla Taylor',    'email' => 'isla@example.com'],
            ['name' => 'Jack Anderson',  'email' => 'jack@example.com'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name'              => $user['name'],
                    'password'          => Hash::make('password'),
                    'is_admin'          => false,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
