@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px">
        <h1>Управление новостями</h1>
        <a class="btn-primary" href="{{ route('admin.articles.create') }}">+ Добавить новость</a>
    </div>

    @foreach ($articles as $article)
        <div class="card" style="display:flex;align-items:center;gap:16px">
            <div style="flex:1">
                <h2 style="font-size:17px"><a href="{{ route('news.show', $article) }}">{{ $article->title }}</a></h2>
                <div class="meta">
                    {{ $article->category->name }} · {{ $article->author }} ·
                    {{ $article->published_at?->format('d.m.Y H:i') }}
                </div>
            </div>
            <a class="btn-primary btn-small" href="{{ route('admin.articles.edit', $article) }}">Редактировать</a>
            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}"
                  onsubmit="return confirm('Удалить новость «{{ $article->title }}»?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-primary btn-small btn-danger">Удалить</button>
            </form>
        </div>
    @endforeach

    <div class="pagination">{{ $articles->links() }}</div>
@endsection
