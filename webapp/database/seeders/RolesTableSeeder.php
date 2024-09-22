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
            [
                'title' => 'Manager',
                'description' => 'Manages users, teams, and resources with some administrative privileges.'
            ],
            [
                'title' => 'Editor',
                'description' => 'Can create and edit content but does not have access to system settings.'
            ],
            [
                'title' => 'Viewer',
                'description' => 'Read-only access to view data and reports, with no permissions to modify content.'
            ],
            [
                'title' => 'Moderator',
                'description' => 'Manages and moderates user-generated content like comments, posts, or reviews.'
            ],
            [
                'title' => 'Analyst',
                'description' => 'Access to view reports and analytics, but cannot modify data or content.'
            ],
            [
                'title' => 'Developer',
                'description' => 'Access to technical tools and developer settings for system configuration and debugging.'
            ],
            [
                'title' => 'Support',
                'description' => 'Handles user support, resolves issues, and manages support tickets.'
            ],
            [
                'title' => 'Guest',
                'description' => 'Temporary or limited access with minimal privileges, usually for external visitors or trial users.'
            ],
            [
                'title' => 'Super Admin',
                'description' => 'Highest level of control over the system, including all administrative and user management rights.'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
