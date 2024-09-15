<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index');
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

            // Select specific fields from Users table

            $users = User::select('id', 'name', 'email', 'is_ldap', 'is_admin')->get();

            // Filter and map users using collections
            $filteredUsers = collect($users)->filter(function ($user) use ($search) {

                // Apply search filter
                if ($search) {
                    return str_contains(strtolower($user->name), $search) ||
                        str_contains(strtolower($user->email), $search);
                }

                return true;
            })->map(function ($user) {
                // Map user data
                return $user;
            })->sortBy('name');

            $total = $filteredUsers->count();

            // Manually paginate results
            $paginatedUsers = $filteredUsers->slice(($page - 1) * $itemsPerPage, $itemsPerPage)->values();

            // Response structure
            return response()->json([
                'items' => $paginatedUsers,
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
        return Inertia::render('Users/Create');
    }

    public function store()
    {
        User::create(request()->all());
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        //if password is not provided, update other fields
        if (request('password') == null) {
            $user->update(request()->except('password'));
            return redirect()->route('users.index');
        } else {
            //if password is provided, update all fields
            $user->update(request()->all());
            return redirect()->route('users.index');
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function show(User $user)
    {
        return Inertia::render('Users/Show', ['user' => $user]);
    }
}
