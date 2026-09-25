@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="card" style="max-width:420px;margin:40px auto">
        <h1 style="margin-bottom:16px">Вход на сайт</h1>

        @if ($errors->any())
            <p style="color:#c0392b;margin-bottom:12px">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <label style="display:block;margin-bottom:4px;font-weight:600">Логин или email</label>
            <input type="text" name="email" value="{{ old('email') }}" required autofocus
                   style="width:100%;padding:10px;margin-bottom:14px;border:1px solid #ccc;border-radius:6px">

            <label style="display:block;margin-bottom:4px;font-weight:600">Пароль</label>
            <input type="password" name="password" required
                   style="width:100%;padding:10px;margin-bottom:14px;border:1px solid #ccc;border-radius:6px">

            <label style="display:block;margin-bottom:16px;font-size:14px">
                <input type="checkbox" name="remember"> Запомнить меня
            </label>

            <button type="submit" class="btn-primary">Войти</button>
        </form>
    </div>
@endsection
