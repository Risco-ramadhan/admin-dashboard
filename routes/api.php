<?php

use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->group(function () {
Route::prefix('itam')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/fetch', [DashboardController::class, 'countCardDashboard']);
        Route::get('/get-lisence', [DashboardController::class, 'getLicense']);
    });
});
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
