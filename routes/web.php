<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EntryController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard', [EntryController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/entries', [EntryController::class, 'index'])->middleware(['auth', 'verified'])->name('entries.index');
Route::post('/entries', [EntryController::class, 'store'])->middleware(['auth', 'verified'])->name('entries.store');

// Route user registers
Route::get('/users', [EntryController::class, 'registers'])->middleware(['auth', 'verified'])->name('users.index');

// Route admin
Route::get('/admin', [EntryController::class, 'administrador'])->name('admin');
Route::patch('/admin/users_aprove/{id}', [EntryController::class, 'users_aprove'])->name('admin.users_aprove.update');
Route::delete('/admin/users_aprove/{id}', [EntryController::class, 'users_aprove_destroy'])->name('admin.users_aprove.destroy');

// Route places
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('places', PlaceController::class);
});

// Route users
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    // Route para agregar un registro
    Route::post('users/{user}/registrations', [UserController::class, 'addRegistration'])->name('users.addRegistration');

    // Route para eliminar un registro
    Route::delete('users/{registration}/registrations', [UserController::class, 'deleteRegistration'])->name('users.deleteRegistration');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
