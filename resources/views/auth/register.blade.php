@extends('layouts.main')

@section('title', 'Регистрация')

@section('content')
    <h1 class="page-head">Регистрация</h1>

    <div class="row">
        <div class="col-md-5">
            <form method="POST" action="{{ route('auth.register') }}" class="card news-card">
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

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Повторите пароль</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Создать аккаунт</button>
                </div>
            </form>

            <p class="mt-3">
                Уже регистрировались? <a href="{{ route('auth.login') }}">Войти</a>
            </p>
        </div>
    </div>
@endsection
