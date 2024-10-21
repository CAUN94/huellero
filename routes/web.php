<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EntryController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard', [EntryController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/entries', [EntryController::class, 'index'])->middleware(['auth', 'verified'])->name('entries.index');
Route::post('/entries', [EntryController::class, 'store'])->middleware(['auth', 'verified'])->name('entries.store');

// Route user registers
Route::get('/users', [EntryController::class, 'registers'])->middleware(['auth', 'verified'])->name('users.index');

// Route admin
Route::get('/admin', [EntryController::class, 'administrador'])->name('admin');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
