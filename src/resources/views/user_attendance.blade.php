@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_attendance.css') }}">
@endsection

@section('content')
<div class="user-attendance__content">
    <div class="user-info">
        <h1>{{ $user->name }}の勤怠記録</h1>
    </div>
    
    <div class="month-navigation">
        <h2>{{ $date->format('Y年m月') }}</h2>
    </div>

    <div class="table-container">
        <table class="user-attendance__table">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>出勤時間</th>
                    <th>退勤時間</th>
                    <th>休憩時間</th>
                    <th>労働時間</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->start_time }}</td>
                    <td>{{ $attendance->end_time }}</td>
                    <td>{{ $attendance->total_break_time }}</td>
                    <td>{{ $attendance->working_hours }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection