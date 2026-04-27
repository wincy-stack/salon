<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Userlogin;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('login.login');
});

Route::get('/salon', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('login.login');
});

Route::get('/register', [Userlogin::class, 'showRegister']);
Route::post('/register', [Userlogin::class, 'register']);
Route::post('/login', [Userlogin::class, 'login']);
Route::post('/logout', [Userlogin::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('services', ServiceController::class);
    Route::resource('bookings', BookingController::class)->except(['edit','update']);
    Route::resource('customers', CustomerController::class);
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{booking}/process', [PaymentController::class, 'process'])->name('payments.process');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');

});