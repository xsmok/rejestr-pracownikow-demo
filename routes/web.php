<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmployeeWorkDayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyTimeController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\WorkDayController;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:6,1');
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:6,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('/my-time', [MyTimeController::class, 'index'])->middleware('role:employee')->name('my-time');

    Route::middleware('role:supervisor,admin')->group(function () {
        Route::get('/summary', [SummaryController::class, 'index'])->name('summary');
        Route::get('/employees/{employee}/work-days', [EmployeeWorkDayController::class, 'index'])->name('employees.work-days.index');
        Route::post('/employees/{employee}/work-days', [WorkDayController::class, 'store'])->name('employees.work-days.store');
        Route::get('/work-days/{workDay}/edit', [WorkDayController::class, 'edit'])->name('work-days.edit');
        Route::put('/work-days/{workDay}', [WorkDayController::class, 'update'])->name('work-days.update');
        Route::delete('/work-days/{workDay}', [WorkDayController::class, 'destroy'])->name('work-days.destroy');
    });

    Route::get('/work-days/{workDay}', [WorkDayController::class, 'show'])->can('view', 'workDay')->name('work-days.show');

    Route::post('/work-days/{workDay}/comments', [CommentController::class, 'store'])
        ->can('create', [Comment::class, 'workDay'])
        ->name('work-days.comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->can('update', 'comment')->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->can('update', 'comment')->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->can('delete', 'comment')->name('comments.destroy');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });
});
