<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function showRegister()
{
    return view('auth.register');
}

public function register(Request $request)
{
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255', 'unique:users,name'],
        'password' => ['required', 'string', 'min:3', 'confirmed'],
    ], [], [
        'name' => 'логин',
        'password' => 'пароль',
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['name'] . '@local.test', // email обязателен в таблице
        'password' => $data['password'], // cast hashed сам захеширует
        'role' => 'user',
        'is_admin' => false,
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('news.index');
}



}
