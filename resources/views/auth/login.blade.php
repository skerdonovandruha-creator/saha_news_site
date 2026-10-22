@extends('layouts.main')

@section('title', 'Вход')

@section('content')
    <h1 class="page-head">Вход</h1>

    <div class="row">
        <div class="col-md-5">
            <form method="POST" action="{{ route('auth.login') }}" class="card news-card">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" class="form-control" id="login" name="login"
                               value="{{ old('login') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Войти</button>
                </div>
            </form>

            <p class="mt-3">
                Ещё нет аккаунта? <a href="{{ route('auth.register') }}">Регистрация</a>
            </p>
        </div>
    </div>
@endsection
