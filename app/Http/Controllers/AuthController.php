<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Вход по логину (name) или email
        $login = $credentials['email'];
        $fields = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? ['email' => $login]
            : ['name' => $login];
        $fields['password'] = $credentials['password'];

        if (Auth::attempt($fields, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('news.index'));
        }

        return back()->withErrors([
            'email' => 'Неверный логин или пароль.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('news.index');
    }
}
