<?php

namespace App\Http\Controllers;

use App\Models\Category;

// Показывает статьи только одной категории
class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // берём статьи через связь модели категории
        $texts = $category->texts()
            ->with(['category', 'user'])
            ->orderByDesc('created_at')
            ->paginate(6);

        return view('news.category', compact('texts', 'category'));
    }
}
