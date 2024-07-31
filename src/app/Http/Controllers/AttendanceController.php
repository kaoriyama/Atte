<?php

namespace App\Http\Controllers;

use App\Models\AttendanceStatus;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;

class AttendanceController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $today)
            ->first();
        
        return view('index', compact('attendance'));
    }

    public function startWork()
    {
    $today = now()->toDateString();
    $attendance = Attendance::where('user_id', auth()->id())
        ->whereDate('date', $today)
        ->first();

    if (!$attendance) {
        Attendance::create([
            'user_id' => auth()->id(),
            'date' => $today,
            'start_time' => now()->toTimeString()
        ]);
    } elseif (!$attendance->start_time) {
        $attendance->update(['start_time' => now()->toTimeString()]);
    }

    return redirect()->route('attendance.index');
    }

    public function endWork()
    {
        $today = now()->toDateString();
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $today)
            ->first();
        
        if ($attendance) {
            $attendance->update(['end_time' => now()->toTimeString()]);
        }
        
        return redirect()->route('attendance.index');
    }

    public function startBreak()
    {
        $today = now()->toDateString();
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $today)
            ->first();
        
        if ($attendance) {
            $attendance->rests()->create(['break_start' => now()->toTimeString()]);
        }
        
        return redirect()->route('attendance.index');
    }

    public function endBreak()
    {
        $today = now()->toDateString();
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $today)
            ->first();
        
        if ($attendance) {
            $lastRest = $attendance->rests()->whereNull('break_end')->latest()->first();
            if ($lastRest) {
                $lastRest->update(['break_end' => now()->toTimeString()]);
            }
        }
        
        return redirect()->route('attendance.index');
    }
}