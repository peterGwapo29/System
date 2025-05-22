<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;

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

    // ACCOUNT
    Route::get('/account', [AccountController::class, 'account'])->name('account');
    Route::post('/account', [AccountController::class, 'store'])->name('accounts.store');
    Route::post('/insert', [AccountController::class, 'insert']);
    Route::get('/studentAccount/list', [AccountController::class, 'studentAcc_dataTables'])->name('studentAcc_dataTables');
    Route::post('/account/update', [AccountController::class, 'update_account']);


    Route::delete('/account/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
    Route::put('/account/{id}', [AccountController::class, 'update'])->name('accounts.update');


    Route::get('/student', [StudentController::class, 'student'])->name('student');


    Route::get('/membership', [MembershipController::class, 'membership'])->name('membership');


    Route::get('/club', [ClubController::class, 'club'])->name('club');


    Route::get('/event', [EventController::class, 'event'])->name('event');


    Route::get('/event_reg', [EventRegistrationController::class, 'event_reg'])->name('event_reg');

});

require __DIR__.'/auth.php';
