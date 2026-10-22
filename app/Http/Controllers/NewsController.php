<?php

namespace App\Http\Controllers;

use App\Models\Text;

// Главная страница со всеми новостями
class NewsController extends Controller
{
    public function index()
    {
        // все статьи, свежие вверху, по 6 штук на страницу
        $texts = Text::with(['category', 'user'])
            ->orderByDesc('created_at')
            ->paginate(6);

        return view('news.index', compact('texts'));
    }
}
