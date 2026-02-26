<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/create', function () {
    return view('colocation.create');
});
Route::middleware('auth')->group(function () {
    Route::get('/create', [ColocationController::class, 'CreateColocation'])->name('colocation.create');
    Route::post('/colocation/store', [ColocationController::class, 'storeColocation'])->name('Colocation.store');
});
require __DIR__.'/auth.php';
