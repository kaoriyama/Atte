@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_list.css') }}">
@endsection

@section('content')
<div class="container">
    <h1>ユーザー一覧</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>アクション</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('attendance.user', $user->id) }}" class="btn btn-primary">勤怠記録を見る</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection