<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

// Достаёт в раздел только те роли, которые перечислены в маршруте.
// Пример: ->middleware('role:journalist,admin')
class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // не пускаем гостя — пусть войдёт
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $userRole = Auth::user()->role->name;

        // если роли пользователя нет в списке — доступ закрыт
        if (!in_array($userRole, $roles)) {
            abort(403, 'Вам недоступен этот раздел.');
        }

        return $next($request);
    }
}
