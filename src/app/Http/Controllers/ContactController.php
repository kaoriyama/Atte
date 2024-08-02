<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // ... 既存のメソッドはそのまま残します ...

    public function showDate(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $carbonDate = Carbon::parse($date);

        $attendances = Attendance::with(['user', 'rests'])
            ->whereDate('date', $date)
            ->get()
            ->map(function ($attendance) {
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