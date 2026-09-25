<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')
            ->latest('published_at')
            ->paginate(6);

        $categories = Category::withCount('articles')->orderBy('name')->get();

        return view('news.index', compact('articles', 'categories'));
    }

    public function show(Article $article)
    {
        $article->load('category');

        $related = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news.show', compact('article', 'related'));
    }

    public function category(Request $request, Category $category)
    {
        // "Переадресация на категории": если в URL есть ?to=1, редиректим
        // на канонический путь категории, иначе показываем её список.
        if ($request->boolean('to')) {
            return redirect()->route('news.category', $category);
        }

        $articles = $category->articles()
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $categories = Category::withCount('articles')->orderBy('name')->get();

        return view('news.category', compact('category', 'articles', 'categories'));
    }
}
