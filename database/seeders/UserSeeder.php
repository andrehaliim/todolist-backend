<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
              'name' => 'Admin',
              'username' => 'admin',
              'email' => 'admin@email.com',
              'role' => 'admin',
              'password' => Hash::make('welcome48'),
              'is_active' => 1
            ]
        ];

        User::insert($users);
    }
}
