@extends('layouts.main')

@section('title', 'Админ — статьи')

@section('content')
    <h1 class="page-head">Админ: все статьи</h1>

    <p class="text-muted">
        Всего статей: {{ $texts->count() }}
        &nbsp;|&nbsp;
        <a href="{{ route('admin.users') }}">Пользователи и роли</a>
    </p>

    @forelse ($texts as $item)
        <div class="card news-card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="h6 mb-1">{{ $item->heading }}</h2>
                        <small class="text-muted">
                            {{ $item->category->name }} · автор {{ $item->user->login }} ·
                            {{ $item->created_at->format('d.m.Y H:i') }}
                        </small>
                    </div>

                    {{-- удаление статьи --}}
                    <form method="POST" action="{{ route('admin.article.remove', $item) }}"
                          onsubmit="return confirm('Удалить эту статью?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                    </form>
                </div>

                {{-- редактирование статьи --}}
                <details class="mt-3">
                    <summary>Редактировать</summary>

                    <form method="POST" action="{{ route('admin.article.update', $item) }}" class="mt-3">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Заголовок</label>
                            <input type="text" name="heading" class="form-control"
                                   value="{{ old('heading', $item->heading) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category_id" class="form-select" required>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        @selected(old('category_id', $item->category_id) == $cat->id)>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Текст</label>
                            <textarea name="text" class="form-control" rows="6" required>{{ old('text', $item->text) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
                    </form>
                </details>
            </div>
        </div>
    @empty
        <p class="text-muted">Статей нет.</p>
    @endforelse
@endsection
