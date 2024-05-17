<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\OrderController;

Route::post('/login', [LoginController::class, 'login']); // Login

// Protected routes by Laravel Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']); // Retrieving all users data
    Route::post('/users', [UserController::class, 'store']); // Storing or creating new user
    Route::get('/users/{user}', [UserController::class, 'show']); // Retrieving the selected user data
    Route::put('/users/{user}', [UserController::class, 'update']); // Updating user data
    Route::get('/user', [UserController::class, 'currentUser']); // Route for retrieving the authenticated user data
    Route::post('/users/{user}/edit_picture', [UserController::class, 'editPicture']); // Route for editing user profile picture
    Route::delete('/users/{user}', [UserController::class, 'destroy']); //Deleting user data

    Route::apiResource('occupations', OccupationController::class); // API route for occupations table
    Route::apiResource('salaries', SalaryController::class); // API route for salaries table
    Route::apiResource('tasks', TaskController::class); // API route for tasks table
    Route::apiResource('orders', OrderController::class); // API route for orders table

    Route::post('/logout', [LoginController::class, 'logout']); // Logout
});
