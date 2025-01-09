<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Itam\AssetController;
use App\Http\Controllers\Itam\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/rumah', function () {
    return Inertia::render('Home');
});

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Controller::class, 'index'])->name('dashboard');

    Route::resource('user', UserController::class);

    Route::resource('role', RoleController::class);

    Route::resource('menu', MenuController::class);

    Route::resource('permission', PermissionController::class);

    Route::prefix('itam')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('itam.dashboard');
    });
});






require __DIR__ . '/auth.php';
