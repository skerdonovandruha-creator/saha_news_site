{{-- Простая пагинация: номера страниц + назад/вперёд --}}
@if ($items->hasPages())
    <nav class="mt-4">
        <ul class="pagination justify-content-center">

            <li class="page-item {{ $items->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $items->previousPageUrl() }}">Назад</a>
            </li>

            @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $items->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $items->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $items->nextPageUrl() }}">Вперёд</a>
            </li>

        </ul>
    </nav>
@endif
