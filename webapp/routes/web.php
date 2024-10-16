<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LdapController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\ShipRealtimePositionController;
use App\Http\Controllers\ShipHistoricalPositionController;
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

    Route::resource('/roles', RoleController::class);
    Route::post('/roles/list', [RoleController::class, 'list'])->name('roles.list');

    Route::get('/ldap', [LdapController::class, 'index'])->name('ldap.index');
    Route::post('/ldap/list', [LdapController::class, 'list'])->name('ldap.list');
    Route::post('/ldap/add', [LdapController::class, 'add'])->name('ldap.add');
    Route::post('/ldap/remove', [LdapController::class, 'remove'])->name('ldap.remove');

    Route::resource('ships', ShipController::class);
    Route::post('/ships/list', [ShipController::class, 'list'])->name('ships.list');

    Route::resource('ship-realtime-positions', ShipRealtimePositionController::class);
    Route::post('/ship-realtime-positions/list', [ShipRealtimePositionController::class, 'list'])->name('ship-realtime-positions.list');

    Route::resource('ship-historical-positions', ShipHistoricalPositionController::class);
    Route::post('/ship-historical-positions/list', [ShipHistoricalPositionController::class, 'list'])->name('ship-historical-positions.list');
});

require __DIR__ . '/auth.php';
