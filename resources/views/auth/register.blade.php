@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <div class="card" style="max-width:420px;margin:40px auto">
        <h1 style="margin-bottom:16px">Регистрация</h1>

        @if ($errors->any())
            <p style="color:#c0392b;margin-bottom:12px">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('register.attempt') }}">
            @csrf
            <label style="display:block;margin-bottom:4px;font-weight:600">Логин</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   style="width:100%;padding:10px;margin-bottom:14px;border:1px solid #ccc;border-radius:6px">

            <label style="display:block;margin-bottom:4px;font-weight:600">Пароль</label>
            <input type="password" name="password" required
                   style="width:100%;padding:10px;margin-bottom:14px;border:1px solid #ccc;border-radius:6px">

            <label style="display:block;margin-bottom:4px;font-weight:600">Подтверждение пароля</label>
            <input type="password" name="password_confirmation" required
                   style="width:100%;padding:10px;margin-bottom:16px;border:1px solid #ccc;border-radius:6px">

            <button type="submit" class="btn-primary">Зарегистрироваться</button>
            <p style="margin-top:14px;font-size:14px">
                Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
            </p>
        </form>
    </div>
@endsection