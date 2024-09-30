<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Users
            [
                'id' => 1,
                'title' => 'users_create',
                'description' => 'Create users',
            ],
            [
                'id' => 2,
                'title' => 'users_edit',
                'description' => 'Edit users',
            ],
            [
                'id' => 3,
                'title' => 'users_destroy',
                'description' => 'Destroy users',
            ],
            [
                'id' => 4,
                'title' => 'users_show',
                'description' => 'Show users',
            ],
            [
                'id' => 5,
                'title' => 'users_list',
                'description' => 'List users',
            ],

            // Roles
            [
                'id' => 6,
                'title' => 'roles_create',
                'description' => 'Create roles',
            ],
            [
                'id' => 7,
                'title' => 'roles_edit',
                'description' => 'Edit roles',
            ],
            [
                'id' => 8,
                'title' => 'roles_destroy',
                'description' => 'Destroy roles',
            ],
            [
                'id' => 9,
                'title' => 'roles_show',
                'description' => 'Show roles',
            ],
            [
                'id' => 10,
                'title' => 'roles_list',
                'description' => 'List roles',
            ]
        ];

        Permission::insert($permissions);
    }
}
