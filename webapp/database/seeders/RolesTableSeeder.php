<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'title' => 'Admin',
                'description' => 'Full access to all system settings and management of all resources.'
            ],
            [
                'title' => 'User',
                'description' => 'Basic user access with limited permissions for personal account usage.'
            ],
        ];

        Role::insert($roles);
    }
}
