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
        /**
         * Administrator Role's Permissions
         */
        $ids_to_admin = Permission::all()->pluck('id');

        /* 
        * User Role's Permissions
        */
        Role::findOrFail(1)->permissions()->sync($ids_to_admin);
    }
}
