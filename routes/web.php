<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationColoc;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Routes d'invitation (publiques)
Route::get('/invitation/{token}', [InvitationColoc::class, 'showInvitation'])->name('invitation.show');
Route::get('/invitation-code', [InvitationColoc::class, 'showCodeForm'])->name('invitation.codeForm');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/colocation/dashboard', [ColocationController::class, 'afficherColocation'])->name('colocation.show');
    Route::get('/create', [ColocationController::class, 'CreateColocation'])->name('colocation.create');
    Route::post('/colocation/store', [ColocationController::class, 'storeColocation'])->name('Colocation.store');
    Route::post('/colocation/leave', [ColocationController::class, 'leave'])->name('colocation.leave');
    Route::patch('/colocation/{colocation}/deactivate', [ColocationController::class, 'deactivate'])->name('colocation.deactivate');
    Route::post('/invitation/envoyer/{colocId}', [InvitationColoc::class, 'envoyerInvitation'])->name('invitation.send');
    Route::post('/invitation/accept', [InvitationColoc::class, 'acceptInvitation'])->name('invitation.accept');
    Route::post('/invitation-code/validate', [InvitationColoc::class, 'validateCode'])->name('invitation.byCode');
    Route::get('/invitation/{token}/decline', [InvitationColoc::class, 'declineInvitation'])->name('invitation.decline');
    Route::resource('expenses', ExpenseController::class);
    Route::patch('/expenses/{expense}/mark-as-paid', [ExpenseController::class, 'markAsPaid'])->name('expenses.markAsPaid');
    Route::delete('/colocations/{colocation}', [ColocationController::class, 'destroy'])->name('colocations.destroy');

    // Route spécifique pour marquer comme payé (PaymentController)
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
});
require __DIR__ . '/auth.php';
