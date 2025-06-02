<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AccountController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/accounts', [AccountController::class, 'list']);
    Route::post('/accounts/store', [AccountController::class, 'store']);
    Route::delete('/accounts/delete/{id}', [AccountController::class, 'delete']);
});