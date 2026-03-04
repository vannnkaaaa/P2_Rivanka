<?php

use App\Http\Controllers\AgentC;
use App\Http\Controllers\JemaahC;
use App\Http\Controllers\AuthC;
use App\Http\Controllers\DashC;
use App\Http\Controllers\BookingC;
use App\Http\Controllers\LandingpageC;
use App\Http\Controllers\PackageC;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::middleware(['role:admin'])->group(function () {
    // admin routes
});

Route::get('/', [LandingpageC::class, 'index'])->name('landingpage');
Route::get('/paket/{type}', [LandingpageC::class, 'index'])->name('landing.paket');
Route::get('/paket/{type}/{slug}', [LandingpageC::class, 'show'])->name('landing.detail');

Route::get('/login', [AuthC::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthC::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthC::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthC::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthC::class, 'registerJemaah'])->name('jemaah.register.submit');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashC::class, 'admin'])
            ->name('admin.dashboard');
    });

    Route::prefix('agent')->group(function () {
        Route::get('/dashboard', [DashC::class, 'agent'])
            ->name('agent.dashboard');
    });

    Route::prefix('jemaah')->group(function () {
        Route::get('/dashboard', [DashC::class, 'jemaah'])
            ->name('jemaah.dashboard');
    });
});

Route::prefix('agent')->name('agent.')->group(function () {
    Route::get('/', [AgentC::class, 'index'])->name('tabel');
    Route::post('/store', [AgentC::class, 'store'])->name('store');
    Route::get('/view/{id}', [AgentC::class, 'view'])->name('view');
    Route::put('/update/{id}', [AgentC::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [AgentC::class, 'destroy'])->name('delete');
});

Route::prefix('jemaah')->name('jemaah.')->group(function () {
    Route::get('/', [JemaahC::class, 'index'])->name('tabel');
    Route::get('/create', [JemaahC::class, 'create'])->name('form');
    Route::post('/store', [JemaahC::class, 'store'])->name('store');
    Route::get('/view/{id}', [JemaahC::class, 'view'])->name('view');
    Route::put('/update/{id}', [JemaahC::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [JemaahC::class, 'delete'])->name('delete');
});

Route::prefix('package')->name('package.')->group(function () {
    Route::get('/get-next-code/{type}', [PackageC::class, 'getNextCode'])->name('getNextCode');

    // index sekarang optional {type}
    Route::get('/{type?}', [PackageC::class, 'index'])->name('tabel');

    Route::post('/{type}/store', [PackageC::class, 'store'])->name('store');
    Route::get('/{type}/view/{id}', [PackageC::class, 'view'])->name('view');
    Route::put('/{type}/update/{id}', [PackageC::class, 'update'])->name('update');
    Route::delete('/{type}/delete/{id}', [PackageC::class, 'delete'])->name('delete');
    Route::patch('/{type}/{package}/status', [PackageC::class, 'toggleStatus'])->name('set-status');
});

Route::get('/booking/{type}/{id}', [BookingC::class, 'create'])->name('package.booking');
Route::post('/booking/{type}/{id}', [BookingC::class, 'store'])->name('booking.store');
