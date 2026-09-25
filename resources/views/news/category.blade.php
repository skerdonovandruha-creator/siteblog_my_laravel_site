@extends('layouts.app')

@section('title', 'Категория: ' . $category->name)

@section('content')
    <a class="back" href="{{ route('news.index') }}">&larr; На главную</a>

    <h1 style="margin-bottom:18px">
        Категория: {{ $category->name }}
        <small style="color:#aaa;font-size:15px">({{ $articles->total() }})</small>
    </h1>

    @forelse ($articles as $article)
        <article class="card">
            <h2><a href="{{ route('news.show', $article) }}">{{ $article->title }}</a></h2>
            <div class="meta">{{ $article->author }} · {{ $article->published_at?->format('d.m.Y H:i') }}</div>
            <p>{{ $article->excerpt }}</p>
        </article>
    @empty
        <p>В этой категории пока нет новостей.</p>
    @endforelse

    <div class="pagination">{{ $articles->links() }}</div>
@endsection
