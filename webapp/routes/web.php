<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LdapController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('users', UserController::class);
    Route::post('/users/list', [UserController::class, 'list'])->name('users.list');

    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/list', [TaskController::class, 'list'])->name('tasks.list');

    Route::resource('/roles', RoleController::class);
    Route::post('/roles/list', [RoleController::class, 'list'])->name('roles.list');

    Route::get('/ldap', [LdapController::class, 'index'])->name('ldap.index');
    Route::post('/ldap/list', [LdapController::class, 'list'])->name('ldap.list');
    Route::post('/ldap/add', [LdapController::class, 'add'])->name('ldap.add');
    Route::post('/ldap/remove', [LdapController::class, 'remove'])->name('ldap.remove');
    
});

require __DIR__.'/auth.php';
