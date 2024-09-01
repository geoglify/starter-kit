<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('Users/Index', ['users' => $users]);
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
        return redirect()->route('users.index');
    }

    public function import()
    {
        // Import users from LDAP
        return redirect()->route('users.index');
    }
}
