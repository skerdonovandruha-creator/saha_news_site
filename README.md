# ⚡ Технологии сегодня

Учебный новостной сайт на **Laravel 13** + **PostgreSQL**.

---

## Что внутри

| Раздел | Кто заходит | Что делает |
|---|---|---|
| Главная | все | все статьи (новые сверху), пагинация по 6 |
| Категория | все | статьи одной категории |
| Журналист | journalist, admin | форма создания статьи |
| Админ | admin | редактирование/удаление статей, смена ролей |

Плюс регистрация, вход, выход. Пароли — bcrypt.

---

## Структура БД

4 таблицы:

```
roles       — id, name
categories  — id, name
users       — id, role_id → roles, login (unique), password (hash), timestamps
texts       — id, heading, text, category_id → categories, user_id → users, timestamps
```

Связи (Eloquent):

- `Role` hasMany `User` — у роли много пользователей
- `Category` hasMany `Text` — у категории много статей
- `User` hasMany `Text` — у автора много статей
- `Text` belongsTo `Category`, belongsTo `User`
- `User` belongsTo `Role`

Внешние ключи с `onDelete('restrict')`: удалить роль или категорию, на которую
есть ссылки, не получится — PostgreSQL не даст.

---

## Как запустить

### 1. Создать базу в PostgreSQL

В pgAdmin: ПКМ по **Databases** → **Create → Database** → имя `sasha_news`.

Через psql:

```bash
psql -U postgres -c "CREATE DATABASE sasha_news;"
```

### 2. Настроить .env

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sasha_news
DB_USERNAME=postgres
DB_PASSWORD=ваш_пароль
```

### 3. Команды

```bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve --port=8001
```

Открыть: **http://127.0.0.1:8001**

---

## Тестовые аккаунты

| Логин | Пароль | Роль |
|---|---|---|
| `admin` | `123456` | admin — всё |
| `korrespondent` | `123456` | journalist — главная + категория + журналист |
| `chitatel` | `123456` | user — только главная + категория |

---

## Права доступа

Middleware `CheckRole` принимает список разрешённых ролей:

```php
// app/Http/Middleware/CheckRole.php
public function handle($request, Closure $next, string ...$roles)
{
    if (!Auth::check()) {
        return redirect()->route('auth.login');
    }

    if (!in_array(Auth::user()->role->name, $roles)) {
        abort(403, 'Вам недоступен этот раздел.');
    }

    return $next($request);
}
```

В маршрутах (`routes/web.php`):

```php
Route::middleware(['auth', 'role:journalist,admin'])->group(/* ... */);
Route::middleware(['auth', 'role:admin'])->group(/* ... */);
```

---

## Файлы проекта

```
app/Http/Controllers/
  NewsController.php        — главная
  CategoryController.php    — категория
  ArticleController.php     — создание статьи (журналист)
  AdminController.php       — админка: статьи + роли
  AuthController.php        — вход / регистрация / выход

app/Http/Middleware/
  CheckRole.php             — проверка роли

app/Models/
  Role.php, Category.php, User.php, Text.php

database/migrations/        — 4 таблицы с FK и индексами
database/seeders/DatabaseSeeder.php — роли, категории, пользователи, статьи

resources/views/
  layouts/main.blade.php    — common layout
  layouts/header.blade.php  — шапка (отдельный файл)
  layouts/footer.blade.php  — подвал (отдельный файл)
  news/index.blade.php      — главная
  news/category.blade.php   — категория
  journalist/new.blade.php  — форма статьи
  admin/articles.blade.php  — админ: статьи
  admin/users.blade.php     — админ: пользователи + роли
  auth/login.blade.php
  auth/register.blade.php

public/css/style.css        — свои стили поверх Bootstrap 5 (CDN)
```

---

## Стек

- PHP 8.5, Laravel 13.38
- PostgreSQL 17
- Blade + Bootstrap 5 (CDN) + `public/css/style.css`
- Без сторонних пакетов авторизации — всё написано вручную
