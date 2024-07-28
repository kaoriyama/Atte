<?php

namespace App\Http\Controllers;

use App\Models\AttendanceStatus;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $status = AttendanceStatus::where('user_id', auth()->id())->firstOrCreate(['user_id' => auth()->id()]);
        return view('attendance.index', compact('status'));
    }

    public function startWork()
    {
        $status = AttendanceStatus::where('user_id', auth()->id())->first();
        $status->update(['is_working' => true, 'is_on_break' => false]);
        return redirect()->route('attendance.index');
    }

    public function endWork()
    {
        $status = AttendanceStatus::where('user_id', auth()->id())->first();
        $status->update(['is_working' => false, 'is_on_break' => false]);
        return redirect()->route('attendance.index');
    }

    public function startBreak()
    {
        $status = AttendanceStatus::where('user_id', auth()->id())->first();
        $status->update(['is_on_break' => true]);
        return redirect()->route('attendance.index');
    }

    public function endBreak()
    {
        $status = AttendanceStatus::where('user_id', auth()->id())->first();
        $status->update(['is_on_break' => false]);
        return redirect()->route('attendance.index');
    }
}