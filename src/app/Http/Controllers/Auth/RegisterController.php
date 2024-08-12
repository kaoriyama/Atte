<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;


class RegisterController extends Controller
{
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->sendEmailVerificationNotification();

        return $user;
    }

    protected function registered(Request $request, $user)
    {
        event(new Registered($user));

        $this->guard()->logout();

        return redirect()->route('verification.notice')->with('status', '登録が完了しました。メールアドレスの確認をお願いします。');
    }
}