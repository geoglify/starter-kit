<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //create root and default password
        User::create([
            'name' => 'root',
            'email' => 'root@geoglify.com',
            'password' => bcrypt('geoglify2024'),
            'is_ldap' => false,
            'is_admin' => true,
        ]);
    }
}
