@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <h1 style="margin-bottom:18px">Свежие новости</h1>

    @forelse ($articles as $article)
        <article class="card">
            <h2><a href="{{ route('news.show', $article) }}">{{ $article->title }}</a></h2>
            <div class="meta">
                <a class="badge" href="{{ route('news.category', $article->category) }}">
                    {{ $article->category->name }}
                </a>
                {{ $article->author }} · {{ $article->published_at?->format('d.m.Y H:i') }}
            </div>
            <p>{{ $article->excerpt }}</p>
        </article>
    @empty
        <p>Новостей пока нет.</p>
    @endforelse

    <div class="pagination">{{ $articles->links() }}</div>
@endsection
