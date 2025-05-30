<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CourseController;

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
    Route::post('/account/delete', [App\Http\Controllers\AccountController::class, 'deleteAccount'])->name('account.delete');

    //STUDENT
    Route::get('/student', [StudentController::class, 'student'])->name('student');
    Route::get('/student/list', [StudentController::class, 'student_dataTables'])->name('student_dataTables');
    Route::post('/insertStudent', [StudentController::class, 'insertStudent']);
    Route::post('/student/update/{id}', [StudentController::class, 'update']);
    Route::post('/student/delete', [App\Http\Controllers\StudentController::class, 'deleteStudent'])->name('student.delete');
    

    Route::get('/membership', [MembershipController::class, 'membership'])->name('membership');


    Route::get('/club', [ClubController::class, 'club'])->name('club');


    Route::get('/event', [EventController::class, 'event'])->name('event');


    Route::get('/event_reg', [EventRegistrationController::class, 'event_reg'])->name('event_reg');

    //history
    Route::get('/history', [HistoryController::class, 'history_function'])->name('history');
    
});

require __DIR__.'/auth.php';
