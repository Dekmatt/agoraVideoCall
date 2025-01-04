<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController\UserController;
use App\Http\Controllers\StaffController\StaffController;
use App\Http\Controllers\AdminController\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\MeetingController;

// Web Routes
Route::get('/', function () {
    return view('welcome');
});

// Route for registration
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Route for customer dashboard
Route::get('/dashboard', [UserController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');











// Route for staff dashboard
Route::get('/staff-dashboard', [StaffController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('staff.dashboard');

// Add this route for the create meeting page

Route::get('/create-meeting', [MeetingController::class, 'meetingUser'])->name('create.meeting');
Route::get('/joinMeeting/{url}', [MeetingController::class, 'joinMeeting'])->name('joinMeeting');
Route::get('/createMeeting', [MeetingController::class, 'createMeeting'])->name('createMeeting');
Route::get('/saveUserName', [MeetingController::class, 'saveUserName'])->name('saveUserName');
















// Route for admin dashboard
Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

// Group for authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Require additional authentication routes
require __DIR__.'/auth.php';

// Prevent login and logout to back navigation
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Routes for customers
Route::group(['middleware' => ['auth', 'role:customer']], function () {
    Route::get('/customer/dashboard', [UserController::class, 'dashboard'])->name('customer.dashboard');
});

// Routes for staff
Route::group(['middleware' => ['auth', 'role:staff']], function () {
    Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
});

// Routes for admin
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Add routes for 2FA setup and verification
Route::middleware('auth')->group(function () {
    // Show the 2FA setup page with the QR code
    Route::get('/2fa', [TwoFactorController::class, 'show'])->name('2fa.show');
    
    // Handle the 2FA code submission
    Route::post('/2fa', [TwoFactorController::class, 'store'])->name('2fa.store');
});

Route::get('twofactor', [LoginController::class, 'showTwoFactorForm'])->name('auth.twofactor');
Route::post('verify-2fa', [LoginController::class, 'verify2fa'])->name('auth.verify2fa');