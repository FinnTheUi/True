<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Recent Contacts Route
Route::get('/recent-contacts', [DashboardController::class, 'recentContacts'])->middleware('auth')->name('recent.contacts');

// Contacts Resource Routes
Route::resource('contacts', ContactController::class)->middleware('auth');

// Default Home Route
Route::get('/', function () {
    return view('home');
})->name('home');