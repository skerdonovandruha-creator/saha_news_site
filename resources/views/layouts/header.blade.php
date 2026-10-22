@php
    // категории для меню — берём прямо из справочника
    $navCategories = \App\Models\Category::orderBy('name')->get();
    $myRole = auth()->check() ? auth()->user()->role->name : null;
@endphp

<nav class="navbar navbar-expand-lg navbar-dark site-nav mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('news.index') }}">Технологии сегодня</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news.index') }}">Главная</a>
                </li>

                @foreach ($navCategories as $cat)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('category.show', $cat) }}">{{ $cat->name }}</a>
                    </li>
                @endforeach

                @if (in_array($myRole, ['journalist', 'admin']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('journalist.new') }}">Журналист</a>
                    </li>
                @endif

                @if ($myRole === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.articles') }}">Админ</a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.login') }}">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.register') }}">Регистрация</a>
                    </li>
                @else
                    <li class="nav-item">
                        <span class="navbar-text me-3">
                            {{ auth()->user()->login }} ({{ auth()->user()->role->name }})
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light">Выйти</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
