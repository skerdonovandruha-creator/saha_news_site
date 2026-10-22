<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Вход, регистрация и выход
class AuthController extends Controller
{
    // ====== ВХОД ======

    public function showLogin()
    {
        return view('auth.login');
    }

    public function attemptLogin(Request $request)
    {
        $cred = $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Laravel сам ищет пользователя по ключу 'login'
        if (!Auth::attempt($cred)) {
            return back()
                ->withInput()
                ->withErrors(['login' => 'Неверный логин или пароль']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('news.index'));
    }

    // ====== РЕГИСТРАЦИЯ ======

    public function showRegister()
    {
        return view('auth.register');
    }

    public function createAccount(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'min:3', 'max:50', 'unique:users,login'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // новому пользователю сразу выдаём роль 'user'
        $roleId = Role::where('name', 'user')->value('id');

        User::create([
            'login'   => $data['login'],
            'password' => $data['password'],  // cast 'hashed' захеширует сам Laravel
            'role_id' => $roleId,
        ]);

        return redirect()->route('auth.login')
            ->with('status', 'Аккаунт создан, войдите');
    }

    // ====== ВЫХОД ======

    public function doLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('news.index');
    }
}
