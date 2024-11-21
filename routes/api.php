<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PolicyController;
use Illuminate\Support\Facades\Route;


// public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('policy/filter', [PolicyController::class, 'filterPolicies']);
    Route::post('policy/expire', [PolicyController::class, 'checkExpiringPolicies']);
    Route::get('policy/search', [PolicyController::class, 'searchPolicy']);
    Route::delete('policy/{id}', [PolicyController::class, 'destroy'])->middleware('isAdmin');
    Route::resource('policy', PolicyController::class)->except(['destroy']);
});
