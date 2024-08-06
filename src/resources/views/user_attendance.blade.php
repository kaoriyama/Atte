@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_attendance.css') }}">
@endsection

@section('content')
<div class="container">
    <h1>{{ $user->name }}の勤怠記録</h1>
    <h2>{{ $date->format('Y年m月') }}</h2>

    <table class="table">
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

    <form action="{{ route('attendance.user', $user->id) }}" method="GET">
        <input type="month" name="date" value="{{ $date->format('Y-m') }}">
        <button type="submit">月を変更</button>
    </form>
</div>
@endsection