<!-- date.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte - 勤怠管理</title>
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
</head>
<body>
    <header>
        <h1>Atte</h1>
        <nav>
            <ul>
                <li><a href="#">ホーム</a></li>
                <li><a href="#">日付一覧</a></li>
                <li><a href="#">ログアウト</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="date-navigation">
            <a href="#" class="prev">&lt;</a>
            <h2>{{ $date }}</h2>
            <a href="#" class="next">&gt;</a>
        </div>

        <table>
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
        {{ $attendances->links() }}
        @endif
        </div>
    </main>

    <footer>
        <p>&copy; Atte, inc.</p>
    </footer>
</body>
</html>