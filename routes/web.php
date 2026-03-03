<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationColoc;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
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
    Route::get('/colocation/dashboard', [ColocationController::class, 'afficherColocation'])->name('colocation.show');
    Route::get('/create', [ColocationController::class, 'CreateColocation'])->name('colocation.create');
    Route::post('/colocation/store', [ColocationController::class, 'storeColocation'])->name('Colocation.store');
    Route::post('/invitation/envoyer/{colocId}', [InvitationColoc::class, 'envoyerInvitation'])->name('invitation.send');
    Route::get ('/coloc/rejoindre/{token}', [InvitationColoc::class, 'accepterInvitation'])->name('colocation.join');
    Route::post('/coloc/rejoindre/manuel', [InvitationColoc::class, 'accepterInvitation'])->name('colocation.join.manual');
    Route::resource('expenses', ExpenseController::class);

    // Route spécifique pour marquer comme payé (PaymentController)
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
});
require __DIR__ . '/auth.php';
