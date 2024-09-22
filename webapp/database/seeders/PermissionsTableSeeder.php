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
            // Tasks
            [
                'id' => 1,
                'title' => 'tasks_create',
                'description' => 'Create tasks',
            ],
            [
                'id' => 2,
                'title' => 'tasks_edit',
                'description' => 'Edit tasks',
            ],
            [
                'id' => 3,
                'title' => 'tasks_destroy',
                'description' => 'Destroy tasks',
            ],
            [
                'id' => 4,
                'title' => 'tasks_show',
                'description' => 'Show tasks',
            ],
            // Users
            [
                'id' => 5,
                'title' => 'users_create',
                'description' => 'Create users',
            ],
            [
                'id' => 6,
                'title' => 'users_edit',
                'description' => 'Edit users',
            ],
            [
                'id' => 7,
                'title' => 'users_destroy',
                'description' => 'Destroy users',
            ],
            [
                'id' => 8,
                'title' => 'users_show',
                'description' => 'Show users',
            ],
            // Roles
            [
                'id' => 9,
                'title' => 'roles_create',
                'description' => 'Create roles',
            ],
            [
                'id' => 10,
                'title' => 'roles_edit',
                'description' => 'Edit roles',
            ],
            [
                'id' => 11,
                'title' => 'roles_destroy',
                'description' => 'Destroy roles',
            ],
            [
                'id' => 12,
                'title' => 'roles_show',
                'description' => 'Show roles',
            ],
        ];

        Permission::insert($permissions);
    }
}
