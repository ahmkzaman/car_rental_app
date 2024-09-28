<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\CarController as FrontendCarController;
use App\Http\Controllers\Frontend\RentalController as FrontendRentalController;

/*
|--------------------------------------------------------------------------
| Frontend Routes (User Interface)
|--------------------------------------------------------------------------
*/

// Public routes for users to view cars and homepage
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/cars', [FrontendCarController::class, 'index'])->name('cars.index');

// Routes for bookings and rentals (only for logged-in customers)
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/rentals', [FrontendRentalController::class, 'index'])->name('rentals.index');
    Route::post('/rentals', [FrontendRentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{id}', [FrontendRentalController::class, 'show'])->name('rentals.show');
    Route::delete('/rentals/{id}', [FrontendRentalController::class, 'destroy'])->name('rentals.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Admin Dashboard)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Car management routes
    Route::get('/cars', [AdminCarController::class, 'index'])->name('admin.cars.index');
    Route::get('/cars/create', [AdminCarController::class, 'create'])->name('admin.cars.create');
    Route::post('/cars', [AdminCarController::class, 'store'])->name('admin.cars.store');
    Route::get('/cars/{id}/edit', [AdminCarController::class, 'edit'])->name('admin.cars.edit');
    Route::put('/cars/{id}', [AdminCarController::class, 'update'])->name('admin.cars.update');
    Route::delete('/cars/{id}', [AdminCarController::class, 'destroy'])->name('admin.cars.destroy');

    // Rental management routes
    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('admin.rentals.index');
    Route::get('/rentals/{id}', [AdminRentalController::class, 'show'])->name('admin.rentals.show');
    Route::post('/rentals', [AdminRentalController::class, 'store'])->name('admin.rentals.store');
    Route::put('/rentals/{id}', [AdminRentalController::class, 'update'])->name('admin.rentals.update');
    Route::delete('/rentals/{id}', [AdminRentalController::class, 'destroy'])->name('admin.rentals.destroy');

    // Customer management routes
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/customers/{id}', [AdminCustomerController::class, 'show'])->name('admin.customers.show');
    Route::delete('/customers/{id}', [AdminCustomerController::class, 'destroy'])->name('admin.customers.destroy');
});

/*
|--------------------------------------------------------------------------
| Authentication & Profile Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php'; // Includes authentication routes for login, registration, etc.
