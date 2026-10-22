@extends('layouts.main')

@section('title', 'Новая статья')

@section('content')
    <h1 class="page-head">Новая статья</h1>

    <div class="row">
        <div class="col-lg-8">
            <form method="POST" action="{{ route('journalist.save') }}" class="card news-card">
                @csrf
                <div class="card-body">

                    <div class="mb-3">
                        <label for="heading" class="form-label">Заголовок</label>
                        <input type="text" class="form-control @error('heading') is-invalid @enderror"
                               id="heading" name="heading" value="{{ old('heading') }}" required>
                        @error('heading')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Категория</label>
                        <select class="form-select @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="text" class="form-label">Текст статьи</label>
                        <textarea class="form-control @error('text') is-invalid @enderror"
                                  id="text" name="text" rows="10" required>{{ old('text') }}</textarea>
                        @error('text')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Опубликовать</button>
                </div>
            </form>
        </div>
    </div>
@endsection
