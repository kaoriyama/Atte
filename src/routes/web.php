<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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


// 認証済みユーザー用ルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/start-work', [AttendanceController::class, 'startWork'])->name('attendance.start-work');
    Route::post('/attendance/end-work', [AttendanceController::class, 'endWork'])->name('attendance.end-work');
    Route::post('/attendance/start-break', [AttendanceController::class, 'startBreak'])->name('attendance.start-break');
    Route::post('/attendance/end-break', [AttendanceController::class, 'endBreak'])->name('attendance.end-break');
    Route::get('/attendance', [AttendanceController::class, 'showDate'])->name('attendance');
    Route::get('/attendance/user/{userId}', [AttendanceController::class, 'showUserAttendance'])->name('attendance.user');
    Route::get('/users', [AttendanceController::class, 'userList'])->name('users.list');
});

Route::middleware(['verified'])->group(function(){
    return view('auth.verify-email');
});

// メール認証関連ルート
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('attendance.index')->with('message', 'メールアドレスが確認されました。');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '確認リンクを送信しました！');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


