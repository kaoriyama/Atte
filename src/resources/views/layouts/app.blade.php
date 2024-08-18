<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atte</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
        <a class="header__logo" href="/">
          Atte
        </a>
        @if (Auth::check() && Auth::user()->hasVerifiedEmail())
        <nav>
          <ul class="header-nav">
            <li class="header-nav__item">
              <a class="header-nav__link" href="/">ホーム</a>
            </li>
            <li class="header-nav__item">
              <a class="header-nav__link" href="/attendance">日付一覧</a>
            </li>
            <li class="header-nav__item">
              <a class="header-nav__link" href="/users">ユーザー</a>
            </li>
            <li class="header-nav__item">
              <form class="form" action="/logout" method="post">
                @csrf
              <button class="header-nav__button">ログアウト</button>
              </form>
            </li>
          </ul>
        </nav>
        @endif
      </div>
    </div>
  </header>

  <main class="main-content">
    @yield('content')
    <footer class="footer">
      <p class="footer__text">Atte, inc.</p>
    </footer>
  </main>
</body>

</html>