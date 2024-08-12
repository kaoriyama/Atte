@extends('layouts.app')

@section('content')
<div class="verify-email__content">
    <div class="verify-email__card">
        <h2 class="verify-email__header">{{ __('メールアドレス受信確認用のメールを送信しました') }}</h2>

        <div class="verify-email__body">
            <p>{{ auth()->user()->email }} へ受信確認用のメールを送信しました。</p>
            <p>メールをご確認いただき、メールに記載された URL をクリックして、Atteへの登録を完了してください。</p>

            @if (session('resent'))
                <div class="verify-email__alert">
                    {{ __('新しい確認リンクがメールアドレスに送信されました。') }}
                </div>
            @endif

            <h3 class="verify-email__subheader">{{ __('メールが届かない場合') }}</h3>
            <p>受信確認メールが届かない場合、以下をご確認ください。</p>
            <ul class="verify-email__list">
                <li>迷惑メールフォルダに振り分けられていたり、フィルターや転送の設定によって受信ボックス以外の場所に保管されていないかご確認ください</li>
                <li>メールの配信に時間がかかる場合がございます。数分程度待った上で、メールが届いているか再度ご確認ください</li>
                <li>登録にご使用のメールアドレス {{ auth()->user()->email }} が正しいかどうか確認してください。正しくない場合は、メールアドレスを再設定してください</li>
            </ul>

            <form class="verify-email__form" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="verify-email__button">{{ __('確認メールを再送信') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection