<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->latest('published_at')->paginate(10);

        return view('admin.articles', compact('articles'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.article_form', ['article' => null, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $this->validateArticle($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['published_at'] = now();

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Новость добавлена.');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.article_form', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validateArticle($request);

        if ($data['title'] !== $article->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $article->id);
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Новость обновлена.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Новость удалена.');
    }

    private function validateArticle(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'author' => ['required', 'string', 'max:255'],
        ], [], [
            'category_id' => 'категория',
            'title' => 'заголовок',
            'excerpt' => 'краткое описание',
            'body' => 'текст новости',
            'author' => 'автор',
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($this->transliterate($title)) ?: 'news';
        $slug = $base;
        $i = 2;

        while (Article::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /**
     * Простая транслитерация кириллицы для URL.
     */
    private function transliterate(string $title): string
    {
        $map = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        ];

        $lower = mb_strtolower($title);
        $result = '';

        foreach (mb_str_split($lower) as $char) {
            $result .= $map[$char] ?? $char;
        }

        return $result;
    }
}
