<?php

namespace App\Http\Controllers;

use App\Models\AttendanceStatus;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;

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

    public function showDate(Request $request)
    {
    $date = $request->input('date', now()->toDateString());
    $carbonDate = Carbon::parse($date);

    $attendances = Attendance::with(['user', 'rests'])
        ->whereDate('date', $date)
        ->paginate(5); // 1ページあたり5件表示

    $attendances->getCollection()->transform(function ($attendance) {
        $attendance->total_break_time = $this->calculateTotalBreakTime($attendance);
        $attendance->working_hours = $this->calculateWorkingHours($attendance);
        return $attendance;
    });

    return view('attendance', compact('attendances', 'carbonDate'));
    }

    private function calculateTotalBreakTime($attendance)
    {
        $totalBreakTime = $attendance->rests->sum(function ($rest) {
            $start = Carbon::parse($rest->break_start);
            $end = $rest->break_end ? Carbon::parse($rest->break_end) : Carbon::now();
            return $start->diffInSeconds($end);
        });

        return gmdate('H:i:s', $totalBreakTime);
    }

    private function calculateWorkingHours($attendance)
    {
        if (!$attendance->end_time) {
            return '00:00:00';
        }

        $start = Carbon::parse($attendance->start_time);
        $end = Carbon::parse($attendance->end_time);
        $totalWorkTime = $start->diffInSeconds($end);

        $totalBreakTime = $attendance->rests->sum(function ($rest) {
            $breakStart = Carbon::parse($rest->break_start);
            $breakEnd = $rest->break_end ? Carbon::parse($rest->break_end) : Carbon::now();
            return $breakStart->diffInSeconds($breakEnd);
        });

        $workingSeconds = $totalWorkTime - $totalBreakTime;
        return gmdate('H:i:s', max(0, $workingSeconds));
    }
}
