@extends('layouts.app')

@section('title', $article ? 'Редактирование новости' : 'Новая новость')

@section('content')
    <a class="back" href="{{ route('admin.articles.index') }}">&larr; В админ-панель</a>

    <div class="card">
        <h1 style="margin-bottom:18px">{{ $article ? 'Редактирование новости' : 'Новая новость' }}</h1>

        <form method="POST" action="{{ $article ? route('admin.articles.update', $article) : route('admin.articles.store') }}">
            @csrf
            @if ($article) @method('PUT') @endif

            <div class="form-field">
                <label>Категория</label>
                <select name="category_id" required>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id', $article?->category_id) == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="form-errors">{{ $message }}</div> @enderror
            </div>

            <div class="form-field">
                <label>Заголовок</label>
                <input type="text" name="title" value="{{ old('title', $article?->title) }}" required>
                @error('title') <div class="form-errors">{{ $message }}</div> @enderror
            </div>

            <div class="form-field">
                <label>Автор</label>
                <input type="text" name="author" value="{{ old('author', $article?->author ?? 'Редакция') }}" required>
                @error('author') <div class="form-errors">{{ $message }}</div> @enderror
            </div>

            <div class="form-field">
                <label>Краткое описание</label>
                <textarea name="excerpt" rows="2" required>{{ old('excerpt', $article?->excerpt) }}</textarea>
                @error('excerpt') <div class="form-errors">{{ $message }}</div> @enderror
            </div>

            <div class="form-field">
                <label>Текст новости (абзацы разделяй пустой строкой)</label>
                <textarea name="body" rows="10" required>{{ old('body', $article?->body) }}</textarea>
                @error('body') <div class="form-errors">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-primary">
                {{ $article ? 'Сохранить изменения' : 'Добавить новость' }}
            </button>
        </form>
    </div>
@endsection
