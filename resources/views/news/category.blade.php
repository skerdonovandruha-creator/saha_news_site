@extends('layouts.main')

@section('title', 'Категория: ' . $category->name)

@section('content')
    <h1 class="page-head">Категория: {{ $category->name }}</h1>

    <div class="row g-4">
        @forelse ($texts as $item)
            <div class="col-md-6">
                <article class="card news-card h-100">
                    <div class="card-body">
                        <h2 class="h5">{{ $item->heading }}</h2>
                        <p class="mb-0">{{ Str::limit($item->text, 180) }}</p>
                    </div>
                    <div class="card-footer news-meta">
                        <span class="badge text-bg-primary">{{ $item->category->name }}</span>
                        <span>Автор: {{ $item->user->login }}</span>
                        <span>{{ $item->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">В этой категории пока пусто.</p>
            </div>
        @endforelse
    </div>

    @include('layouts.pagination', ['items' => $texts])
@endsection
