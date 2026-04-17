<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\DepartemenController;
use App\Http\Controllers\Master\SubDepartemenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\DepartemenTerlibatController;
use App\Http\Controllers\TugasProduksiController;
use App\Http\Controllers\PersetujuanManagerController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Master\MenuController;



// Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::middleware('auth', 'role:admin|Quality Control')->group(function () {
    // ... route lainnya
    Route::get('master/users', [UserController::class, 'index'])->name('users.index');
    Route::get('master/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('master/users/create', [UserController::class, 'store'])->name('users.store');
    Route::get('master/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('master/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('master/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('master/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('master/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('master/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('master/roles/create', [RoleController::class, 'store'])->name('roles.store');
    Route::get('master/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('master/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('master/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('master/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('master/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('master/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('master/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('master/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('master/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route Khusus Pesanan Wakjoel (Bisa diakses semua yang login)
Route::middleware('auth')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('pesan', [OrderController::class, 'create'])->name('orders.create');
    Route::post('pesan', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('{order}', [OrderController::class, 'show'])->name('orders.show');
});

