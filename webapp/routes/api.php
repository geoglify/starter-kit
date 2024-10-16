<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/auth/token', [AuthController::class, 'generateToken']);

Route::middleware('auth:sanctum')->group(function () {
   
    // Your protected routes here
    
});
