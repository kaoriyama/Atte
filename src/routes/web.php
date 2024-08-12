<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
    });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('home');
    Route::post('/attendance/start-work', [AttendanceController::class, 'startWork'])->name('attendance.start-work');
    Route::post('/attendance/end-work', [AttendanceController::class, 'endWork'])->name('attendance.end-work');
    Route::post('/attendance/start-break', [AttendanceController::class, 'startBreak'])->name('attendance.start-break');
    Route::post('/attendance/end-break', [AttendanceController::class, 'endBreak'])->name('attendance.end-break');
});

Route::get('/attendance', [AttendanceController::class, 'showDate'])->name('attendance')->middleware(['auth', 'verified']);;

Route::get('/attendance/user/{userId}', [AttendanceController::class, 'showUserAttendance'])->name('attendance.user')->middleware(['auth', 'verified']);;

Route::get('/users', [AttendanceController::class, 'userList'])->name('users.list')->middleware(['auth', 'verified']);;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/login')->with('status', 'メールアドレスは既に認証されています。');
    }

    $request->fulfill();

    return redirect('/login')->with('status', 'メールアドレスが認証されました。ログインしてください。');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');