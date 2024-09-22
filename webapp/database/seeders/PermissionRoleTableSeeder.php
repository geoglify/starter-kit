<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ids_to_admin = Permission::whereIn('title', [
            'roles_create',
            'roles_edit',
            'roles_destroy',
            'roles_show',
            'users_create',
            'users_edit',
            'users_destroy',
            'users_show',
            'tasks_create',
            'tasks_edit',
            'tasks_destroy',
            'tasks_show'
        ])->pluck('id');

        Role::findOrFail(1)->permissions()->sync($ids_to_admin);

        $ids_to_user = Permission::whereIn('title', [
            'tasks_create',
            'tasks_edit',
            'tasks_show'
        ])->pluck('id');

        Role::findOrFail(2)->permissions()->sync($ids_to_user);
    }
}
