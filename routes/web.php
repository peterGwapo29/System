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
    Route::post('/accounts/insert', [AccountController::class, 'store']);
    Route::get('/studentAccount/list', [AccountController::class, 'studentAcc_dataTables'])->name('studentAcc_dataTables');
    Route::post('/account/update', [AccountController::class, 'update_account']);
    Route::post('/account/delete', [App\Http\Controllers\AccountController::class, 'deleteAccount'])->name('account.delete');
    Route::post('/account/restore', [App\Http\Controllers\AccountController::class, 'restoreAccount'])->name('account.restore');

    //STUDENT
    Route::get('/student', [StudentController::class, 'student'])->name('student');
    Route::get('/student/list', [StudentController::class, 'student_dataTables'])->name('student_dataTables');
    Route::post('/insertStudent', [StudentController::class, 'store'])->name('student.store');
    Route::post('/student/update/{id}', [StudentController::class, 'update']);
    Route::post('/student/delete', [App\Http\Controllers\StudentController::class, 'deleteStudent'])->name('student.delete');
    Route::post('/student/restore', [App\Http\Controllers\StudentController::class, 'restoreStudent'])->name('student.restore');

    //MEMBERSIP
    Route::get('/membership', [MembershipController::class, 'membership'])->name('membership');
    Route::get('/membership/list', [MembershipController::class, 'membership_dataTables'])->name('membership_dataTables');
    Route::post('/insertMembership', [MembershipController::class, 'insertMembership']);
    Route::post('/membership/update', [MembershipController::class, 'update'])->name('membership.update');
    Route::post('/membership/delete/{id}', [MembershipController::class, 'delete'])->name('membership.delete');
    Route::post('/membership/restore/{id}', [MembershipController::class, 'restore'])->name('membership.restore');

    //CLUB
    Route::get('/club', [ClubController::class, 'club'])->name('club');
    Route::get('/club/list', [ClubController::class, 'clubList'])->name('club.list');
    Route::post('/club/insert', [ClubController::class, 'store'])->name('club.store');
    Route::post('/club/update', [ClubController::class, 'update'])->name('club.update');
    Route::post('/club/delete', [ClubController::class, 'deleteClub'])->name('club.deleteClub');
    Route::post('/club/restore', [ClubController::class, 'restoreClub'])->name('club.restore');

    
    //Event
    Route::get('/event', [EventController::class, 'event'])->name('event');
    Route::get('/event/list', [EventController::class, 'eventList'])->name('eventList');
    Route::post('/insertEvent', [EventController::class, 'store'])->name('event.store');
    Route::post('/event/update', [EventController::class, 'update'])->name('event.update');
    Route::post('/event/delete', [EventController::class, 'deleteEvent'])->name('event.delete');
    Route::post('/event/restore', [EventController::class, 'restoreEvent'])->name('event.restore');


    Route::get('/event_reg', [EventRegistrationController::class, 'event_reg'])->name('event_reg');
    Route::get('/event_registration/list', [EventRegistrationController::class, 'event_regList'])->name('event_regList');
    Route::post('/update-registration-status', [EventRegistrationController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/active-events', [EventRegistrationController::class, 'getActiveEvents'])->name('getActiveEvents');
    Route::get('/available-students', [EventRegistrationController::class, 'getAvailableStudents'])->name('getAvailableStudents');
    Route::post('/register-event', [EventRegistrationController::class, 'registerEvent'])->name('registerEvent');
    
});

require __DIR__.'/auth.php';
