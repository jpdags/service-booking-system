<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReviewController;

// ------------------------
// AUTH ROUTES
// ------------------------
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ------------------------
// BUYER ROUTES
// ------------------------
Route::middleware(['auth'])->group(function () {
    // Buyer dashboard
    Route::get('/buyer/dashboard', function() {
        return view('buyer.dashboard');
    })->name('buyer.dashboard')->middleware('role:buyer');

    // Browse services
    Route::get('/services', [ServiceController::class, 'index'])->name('buyer.services')->middleware('role:buyer');

    // Request service
    Route::post('/services/request/{serviceId}', [BookingController::class, 'request'])->name('service.request')->middleware('role:buyer');

    // Buyer bookings
    Route::get('/buyer/bookings', [BookingController::class, 'buyerBookings'])->name('buyer.bookings')->middleware('role:buyer');

    // Messaging
    Route::get('/messages', [MessageController::class, 'index'])->name('messages')->middleware('role:buyer');
    Route::get('/messages/thread/{userId}', [MessageController::class, 'thread'])->name('messages.thread')->middleware('role:buyer');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send')->middleware('role:buyer');

    // Reviews
    Route::post('/reviews/{bookingId}', [ReviewController::class, 'store'])->name('review.store')->middleware('role:buyer');
});

// ------------------------
// SELLER ROUTES
// ------------------------
Route::middleware(['auth'])->group(function () {
    // Seller dashboard
    Route::get('/seller/dashboard', function() {
        return view('seller.dashboard');
    })->name('seller.dashboard')->middleware('role:seller');

    // Seller's own services
    Route::get('/seller/services', [ServiceController::class, 'myServices'])->name('seller.services')->middleware('role:seller');
    Route::post('/seller/services/add', [ServiceController::class, 'store'])->name('service.add')->middleware('role:seller');
    Route::post('/seller/services/update/{id}', [ServiceController::class, 'update'])->name('service.update')->middleware('role:seller');
    Route::delete('/seller/services/delete/{id}', [ServiceController::class, 'destroy'])->name('service.delete')->middleware('role:seller');

    // Seller bookings
    Route::get('/seller/bookings', [BookingController::class, 'sellerBookings'])->name('seller.bookings')->middleware('role:seller');
    Route::post('/seller/bookings/approve/{id}', [BookingController::class, 'approve'])->name('booking.approve')->middleware('role:seller');
    Route::post('/seller/bookings/decline/{id}', [BookingController::class, 'decline'])->name('booking.decline')->middleware('role:seller');

    // Messaging
    Route::get('/seller/messages', [MessageController::class, 'index'])->name('seller.messages')->middleware('role:seller');
    Route::get('/seller/messages/thread/{userId}', [MessageController::class, 'thread'])->name('seller.messages.thread')->middleware('role:seller');
    Route::post('/seller/messages/send', [MessageController::class, 'send'])->name('seller.messages.send')->middleware('role:seller');
});
