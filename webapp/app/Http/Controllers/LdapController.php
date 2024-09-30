<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Exception;

class LdapController extends Controller
{
    public function index()
    {
        return Inertia::render('Ldap/Index');
    }

    /**
     * List LDAP users.
     */
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

            // Select specific fields from LDAP
            $users = \LdapRecord\Models\ActiveDirectory\User::select('cn', 'title', 'mail', 'department', 'distinguishedname')->get();

            // Filter and map users using collections
            $filteredUsers = collect($users)->filter(function ($user) use ($search) {

                // Check if distinguishedName contains 'OU=Utilizadores' and email is present
                $isUser = isset($user->distinguishedname[0]) && str_contains($user->distinguishedname[0], 'Utilizadores') && isset($user->mail[0]);

                if (!$isUser) {
                    return false;
                }

                // Apply search filter
                if ($search) {
                    return str_contains(strtolower($user->cn[0] ?? ''), $search) ||
                        str_contains(strtolower($user->title[0] ?? ''), $search) ||
                        str_contains(strtolower($user->mail[0] ?? ''), $search) ||
                        str_contains(strtolower($user->department[0] ?? ''), $search);
                }

                return true;
            })->map(function ($user) {
                // Map user data
                return [
                    'name' => $user->cn[0] ?? 'N/A',
                    'title' => $user->title[0] ?? 'N/A',
                    'email' => $user->mail[0] ?? 'N/A',
                    'department' => $user->department[0] ?? 'N/A',
                    'is_imported' => User::where('email', $user->mail[0])->exists(),
                ];
            })->sortBy('id');

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

    /**
     * Add LDAP user to users table.
     */
    public function add(Request $request)
    {
        try {
            // Validate input with default values
            $validated = $request->validate([
                'email' => 'required|email',
                'name' => 'required|string',
            ]);

            // Check if the user exists (including soft deleted)
            $user = User::withTrashed()->where('email', $validated['email'])->first();

            if ($user) {
                if ($user->trashed()) {
                    // Restore the soft-deleted user
                    $user->restore();
                }

                // Update the necessary fields
                $user->update([
                    'name' => $validated['name'],
                    'password' => bcrypt(Str::password(16, true, true, false, false)),
                    'is_ldap' => true,
                ]);

            } else {
                // Create a new user if it doesn't exist
                $user = User::create([
                    'email' => $validated['email'],
                    'name' => $validated['name'],
                    'password' => bcrypt(Str::password(16, true, true, false, false)),
                    'is_ldap' => true,
                ]);
            }

            // Return response
            return response()->json([
                'message' => 'User imported successfully.',
                'user' => $user,
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

    /**
     * Remove LDAP user from users table.
     */
    public function remove(Request $request)
    {
        try {
            // Validate input with default values
            $validated = $request->validate([
                'email' => 'required|email',
            ]);

            // Find user by email
            $user = User::where('email', $validated['email'])->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found.',
                ], 404);
            }

            // Soft delete user
            $user->delete();

            // Return response
            return response()->json([
                'message' => 'User removed successfully.',
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
}
