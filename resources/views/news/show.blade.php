@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <a class="back" href="{{ route('news.index') }}">&larr; На главную</a>

    <article class="card article-body">
        @if (auth()->user()?->is_admin)
            <div style="text-align:right;margin-bottom:10px">
                <a class="btn-primary btn-small" href="{{ route('admin.articles.edit', $article) }}">✎ Редактировать</a>
            </div>
        @endif
        <h1 style="margin-bottom:8px">{{ $article->title }}</h1>
        <div class="meta">
            <a class="badge" href="{{ route('news.category', $article->category) }}">
                {{ $article->category->name }}
            </a>
            {{ $article->author }} · {{ $article->published_at?->format('d.m.Y H:i') }}
        </div>
        @foreach (preg_split('/\R{2,}/', $article->body) as $paragraph)
            <p>{{ $paragraph }}</p>
        @endforeach
    </article>

    @if ($related->isNotEmpty())
        <h3 style="margin:22px 0 12px">Ещё в категории «{{ $article->category->name }}»</h3>
        @foreach ($related as $rel)
            <div class="card">
                <h2 style="font-size:17px"><a href="{{ route('news.show', $rel) }}">{{ $rel->title }}</a></h2>
                <div class="meta">{{ $rel->published_at?->format('d.m.Y H:i') }}</div>
            </div>
        @endforeach
    @endif
@endsection
