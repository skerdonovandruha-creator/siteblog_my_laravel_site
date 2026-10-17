<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NewsHub') — NewsHub</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f4f5f7; color: #222; line-height: 1.6; }
        a { color: #c0392b; text-decoration: none; }
        a:hover { text-decoration: underline; }
        header.site { background: #1a1c20; color: #fff; padding: 16px 0; }
        header.site .container { display: flex; align-items: baseline; gap: 24px; flex-wrap: wrap; }
        .logo { font-size: 26px; font-weight: 800; color: #fff; letter-spacing: 1px; }
        .logo span { color: #e74c3c; }
        nav.cats a { color: #cfd2d6; margin-right: 14px; font-size: 15px; }
        nav.cats a.active, nav.cats a:hover { color: #fff; text-decoration: none; }
        .container { max-width: 1000px; margin: 0 auto; padding: 0 16px; }
        main { padding: 28px 0; }
        .layout { display: grid; grid-template-columns: 1fr 260px; gap: 28px; }
        .card { background: #fff; border-radius: 10px; padding: 20px 22px; margin-bottom: 18px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .card h2 { font-size: 20px; margin-bottom: 6px; }
        .meta { font-size: 13px; color: #888; margin-bottom: 8px; }
        .badge { display: inline-block; background: #e74c3c; color: #fff; font-size: 12px; padding: 2px 10px; border-radius: 20px; margin-right: 8px; }
        .badge:hover { text-decoration: none; opacity: .9; }
        aside .widget { background: #fff; border-radius: 10px; padding: 18px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        aside .widget h3 { font-size: 15px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 12px; }
        aside .widget li { list-style: none; margin-bottom: 8px; }
        .article-body p { margin-bottom: 14px; }
        .back { font-size: 14px; margin-bottom: 16px; display: inline-block; }
        footer.site { background: #1a1c20; color: #9aa0a6; text-align: center; padding: 22px 0; margin-top: 30px; font-size: 14px; }
        .pagination { display: flex; gap: 10px; justify-content: center; margin-top: 20px; }
        .pagination a, .pagination span { padding: 6px 14px; background: #fff; border-radius: 6px; }
        .btn-primary { display: inline-block; background: #e74c3c; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-size: 15px; cursor: pointer; }
        .btn-primary:hover { opacity: .9; text-decoration: none; color: #fff; }
        .btn-small { font-size: 13px; padding: 5px 12px; }
        .btn-danger { background: #7f8c8d; }
        .userbox { margin-left: auto; display: flex; align-items: center; gap: 12px; }
        .userbox a, .userbox span { color: #cfd2d6; font-size: 14px; }
        .userbox form { display: inline; }
        .userbox button { background: none; border: 1px solid #555; color: #cfd2d6; padding: 4px 12px; border-radius: 6px; cursor: pointer; font-size: 13px; }
        .alert-success { background: #d5f5e3; color: #1e8449; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; }
        .form-field { margin-bottom: 14px; }
        .form-field label { display: block; font-weight: 600; margin-bottom: 4px; }
        .form-field input, .form-field select, .form-field textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font: inherit; }
        .form-errors { color: #c0392b; font-size: 13px; margin-top: 3px; }
        @media (max-width: 760px) { .layout { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<header class="site">
    <div class="container">
        <a href="{{ route('news.index') }}" class="logo">News<span>Hub</span></a>
        <nav class="cats">
            @foreach ($sidebarCategories ?? [] as $cat)
                <a href="{{ route('news.category', $cat) }}"
                   class="{{ request()->routeIs('news.category') && request()->route('category')?->id === $cat->id ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </nav>
        <div class="userbox">
    @auth
        @if (auth()->user()->isJournalist())
            <a href="{{ route('admin.articles.index') }}">✍ Панель автора</a>
        @endif
        <span>👤 {{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Выйти</button>
        </form>
    @else
        <a href="{{ route('login') }}">Войти</a>
        <a href="{{ route('register') }}">Регистрация</a>
    @endauth
</div>
    </div>
</header>

<main>
    <div class="container layout">
        <section>
            @yield('content')
        </section>
        <aside>
            <div class="widget">
                <h3>Категории</h3>
                <ul>
                    @foreach ($sidebarCategories ?? [] as $cat)
                        <li>
                            <a href="{{ route('news.category', $cat) }}">
                                {{ $cat->name }} <small style="color:#aaa">({{ $cat->articles_count }})</small>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</main>

<footer class="site">
    <div class="container">NewsHub © {{ date('Y') }} — все новости выдуманы, любые совпадения случайны 😉</div>
</footer>
</body>
</html>
