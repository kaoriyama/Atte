<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
    });

Route::middleware(['auth'])->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/start-work', [AttendanceController::class, 'startWork'])->name('attendance.start-work');
    Route::post('/attendance/end-work', [AttendanceController::class, 'endWork'])->name('attendance.end-work');
    Route::post('/attendance/start-break', [AttendanceController::class, 'startBreak'])->name('attendance.start-break');
    Route::post('/attendance/end-break', [AttendanceController::class, 'endBreak'])->name('attendance.end-break');
});


Route::get('/attendance', [AttendanceController::class, 'showDate'])->name('attendance');

Route::get('/attendance/user/{userId}', [AttendanceController::class, 'showUserAttendance'])->name('attendance.user');

Route::get('/users', [AttendanceController::class, 'userList'])->name('users.list');