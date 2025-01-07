<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DonorController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\SubscriptionController;

    Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('events', EventController::class);
    Route::resource('users', UserController::class);
    Route::resource('donors', DonorController::class);
    Route::resource('donations', DonationController::class);
    Route::resource('subscriptions', SubscriptionController::class);
});


Route::get('/', function () {
    return view('welcome');
});
