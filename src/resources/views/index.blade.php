@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__content">
    <h2 class="attendance__greeting">{{ Auth::user()->name }}さんお疲れ様です！</h2>
    <div class="attendance__panel">
        <form action="{{ route('attendance.start-work') }}" method="POST" class="attendance__button">
            @csrf
            <button type="submit" class="attendance__button-submit" {{ $attendance && $attendance->start_time ? 'disabled' : '' }}>勤務開始</button>
        </form>
        <form action="{{ route('attendance.end-work') }}" method="POST" class="attendance__button">
            @csrf
            <button type="submit" class="attendance__button-submit" {{ !$attendance || !$attendance->start_time || $attendance->end_time ? 'disabled' : '' }}>勤務終了</button>
        </form>
        <form action="{{ route('attendance.start-break') }}" method="POST" class="attendance__button">
            @csrf
            <button type="submit" class="attendance__button-submit" {{ !$attendance || !$attendance->start_time || $attendance->end_time || ($attendance->rests()->whereNull('break_end')->exists()) ? 'disabled' : '' }}>休憩開始</button>
        </form>
        <form action="{{ route('attendance.end-break') }}" method="POST" class="attendance__button">
            @csrf
            <button type="submit" class="attendance__button-submit" {{ !$attendance || !$attendance->start_time || $attendance->end_time || !($attendance->rests()->whereNull('break_end')->exists()) ? 'disabled' : '' }}>休憩終了</button>
        </form>
    </div>
</div>
@endsection