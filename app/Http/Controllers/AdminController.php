<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Text;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

// Админка: управление статьями и ролями пользователей
class AdminController extends Controller
{
    // ====== СТАТЬИ ======

    public function articles()
    {
        // все статьи + список категорий для редактора
        $texts = Text::with(['category', 'user'])
            ->orderByDesc('created_at')
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('admin.articles', compact('texts', 'categories'));
    }

    public function update(Request $request, Text $text)
    {
        $data = $request->validate([
            'heading' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'text' => ['required', 'string', 'min:20'],
        ]);

        $text->update($data);

        return redirect()->route('admin.articles')
            ->with('status', 'Статья обновлена');
    }

    public function remove(Text $text)
    {
        $text->delete();

        return redirect()->route('admin.articles')
            ->with('status', 'Статья удалена');
    }

    // ====== ПОЛЬЗОВАТЕЛИ ======

    public function users()
    {
        // withCount — сразу считаем сколько у кого статей
        $users = User::with('role')->withCount('texts')->orderBy('login')->get();
        $roles = Role::orderBy('name')->get();

        return view('admin.users', compact('users', 'roles'));
    }

    public function changeRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $user->update(['role_id' => $data['role_id']]);

        return redirect()->route('admin.users')
            ->with('status', 'Роль пользователя изменена');
    }
}
