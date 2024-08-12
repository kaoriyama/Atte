@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="attendance__content">
    <div class="date-navigation">
        <a href="{{ route('attendance', ['date' => $carbonDate->copy()->subDay()->toDateString()]) }}" class="prev">&lt;</a>
        <h2>{{ $carbonDate->format('Y-m-d') }}</h2>
        <a href="{{ route('attendance', ['date' => $carbonDate->copy()->addDay()->toDateString()]) }}" class="next">&gt;</a>
    </div>

    <table class="attendance__table">
        <thead>
            <tr>
                <th>名前</th>
                <th>勤務開始</th>
                <th>勤務終了</th>
                <th>休憩時間</th>
                <th>勤務時間</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
            <tr>
                <td>{{ $attendance->user->name }}</td>
                <td>{{ $attendance->start_time }}</td>
                <td>{{ $attendance->end_time }}</td>
                <td>{{ $attendance->total_break_time }}</td>
                <td>{{ $attendance->working_hours }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        @if($attendances instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $attendances->appends(['date' => $carbonDate->toDateString()])->links('pagination::custom') }}
        @endif
    </div>
</div>
@endsection