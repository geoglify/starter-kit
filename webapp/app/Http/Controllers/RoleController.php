<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function index()
    {
        return Inertia::render('Roles/Index');
    }

    public function list(Request $request)
    {

        try {
            // Validate input with default values
            $validated = $request->validate([
                'page' => 'integer|min:1',
                'itemsPerPage' => 'integer|min:1',
                'search' => 'nullable|string',
            ]);

            $page = $validated['page'] ?? 1;
            $itemsPerPage = $validated['itemsPerPage'] ?? 10;
            $search = strtolower($validated['search'] ?? '');

            // Select specific fields from Roles table
            $roles = Role::all();

            // Filter and map roles using collections
            $filteredRoles = collect($roles)->filter(function ($role) use ($search) {

                // Apply search filter
                if ($search) {
                    return str_contains(strtolower($role->title), $search);
                }

                return true;
            })->map(function ($role) {
                // Map role data
                return $role;
            })->sortBy('id');

            $total = $filteredRoles->count();

            // Manually paginate results
            $paginatedRoles = $filteredRoles->slice(($page - 1) * $itemsPerPage, $itemsPerPage)->values();

            // Response structure
            return response()->json([
                'items' => $paginatedRoles,
                'total' => $total,
                'perPage' => $itemsPerPage,
                'currentPage' => $page,
            ]);

        } catch (ValidationException $e) {

            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {

            // Handle general errors
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render('Roles/Create', ['permissions' => $permissions]);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());

        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return Inertia::render('Roles/Edit', ['role' => $role->load('permissions'), 'permissions' => $permissions]);
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        
        $role = Role::findOrFail($id);
        $role->update($request->validated());

        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully']);
    }

    public function show(Role $role)
    {
        return Inertia::render('Roles/Show', ['role' => $role]);
    }
}
