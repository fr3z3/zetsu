<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\JadwalController;

// Halaman utama single page
Route::get('/', [PageController::class, 'home'])->name('home');

// Halaman booking
Route::middleware('auth')->group(function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('booking');
    Route::post('/booking', [BookingController::class, 'submit'])->name('booking.submit');
});

// Dashboard jika login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Pengelolaan profil user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/jadwal/{tanggal}', [JadwalController::class, 'getJadwal']);
// Auth bawaan Laravel Breeze
require __DIR__.'/auth.php';

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// My Booking route
Route::get('/mybooking', [App\Http\Controllers\BookingController::class, 'myBooking'])->name('mybooking');

Route::delete('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

Route::get('/available-times', [BookingController::class, 'getAvailableTimes'])->name('available.times');

Route::post('/booking/booked-times', [BookingController::class, 'getBookedTimes'])->name('booking.bookedTimes');

Route::get('/api/booked-slots', [BookingController::class, 'getBookedSlots']);

Route::get('/admin/all-bookings', [BookingController::class, 'allBookings'])->name('admin.all-bookings');