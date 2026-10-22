<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

// ---------- публичные разделы ----------

// Главная: все статьи, новые сверху
Route::get('/', [NewsController::class, 'index'])->name('news.index');

// Категория: только её статьи
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

// ---------- вход и регистрация (только для гостей) ----------

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'attemptLogin']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'createAccount']);
});

// выход — для вошедших
Route::post('/logout', [AuthController::class, 'doLogout'])->name('auth.logout');

// ---------- раздел «Журналист»: journalist + admin ----------

Route::middleware(['auth', 'role:journalist,admin'])
    ->prefix('journalist')
    ->name('journalist.')
    ->group(function () {
        Route::get('/new', [ArticleController::class, 'create'])->name('new');
        Route::post('/new', [ArticleController::class, 'store'])->name('save');
    });

// ---------- раздел «Админ»: только admin ----------

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/articles', [AdminController::class, 'articles'])->name('articles');
        Route::put('/articles/{text}', [AdminController::class, 'update'])->name('article.update');
        Route::delete('/articles/{text}', [AdminController::class, 'remove'])->name('article.remove');

        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::put('/users/{user}', [AdminController::class, 'changeRole'])->name('user.role');
    });

