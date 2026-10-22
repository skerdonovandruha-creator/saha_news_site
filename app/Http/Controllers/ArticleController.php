<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Text;
use Illuminate\Http\Request;

// Создание статей (доступно журналистам и админам)
class ArticleController extends Controller
{
    // показать форму
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('journalist.new', compact('categories'));
    }

    // сохранить статью
    public function store(Request $request)
    {
        $data = $request->validate([
            'heading' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'text' => ['required', 'string', 'min:20'],
        ]);

        // автор — тот, кто сейчас залогинен
        $data['user_id'] = $request->user()->id;

        Text::create($data);

        return redirect()
            ->route('news.index')
            ->with('status', 'Статья опубликована');
    }
}
