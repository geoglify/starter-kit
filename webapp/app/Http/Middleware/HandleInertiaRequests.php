<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use App\Models\Permission; // Make sure to import the Permission model

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $can = [];

        if ($user) {
            // Check if the user has id = 1, granting all permissions
            if ($user->id === 1) {
                // Get all permissions from the database
                $permissions = Permission::all()->map(function ($permission) {
                    return [$permission['title'] => true]; // Grant all rights
                });
                $can = $permissions->collapse()->all();
            } else {
                // Use the user's permissions
                $permissions = $user->roles()->with('permissions')->get()->flatMap(function ($role) {
                    return $role->permissions;
                });

                $can = $permissions->map(function ($permission) use ($user) {
                    return [$permission['title'] => $user->can($permission['title'])];
                })->collapse()->all();
            }
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'can' => $can,
            ],
            'csrf_token' => $request->session()->token(),
            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
