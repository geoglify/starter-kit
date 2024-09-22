<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@geoglify.com',
                'password' => bcrypt('geoglify2024'),
                'remember_token' => null,
            ],
            [
                'id' => 2,
                'name' => 'User',
                'email' => 'user@geoglify.com',
                'password' => bcrypt('geoglify2024'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
