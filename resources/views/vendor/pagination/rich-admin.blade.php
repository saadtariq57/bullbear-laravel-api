@if ($paginator->hasPages())
    @php
        $lastPage = $paginator->lastPage();
        $currentPage = $paginator->currentPage();
        $pages = [];

        if ($lastPage <= 8) {
            $pages = range(1, $lastPage);
        } else {
            $pages = range(1, min(5, $lastPage));

            $windowStart = max(6, $currentPage - 1);
            $windowEnd = min($lastPage - 2, $currentPage + 1);

            if ($windowStart > 6) {
                $pages[] = 'ellipsis';
            }

            if ($windowStart <= $windowEnd) {
                for ($i = $windowStart; $i <= $windowEnd; $i++) {
                    $pages[] = $i;
                }
            }

            if ($windowEnd < $lastPage - 2) {
                $pages[] = 'ellipsis';
            }

            $pages[] = $lastPage - 1;
            $pages[] = $lastPage;

            $normalized = [];
            foreach ($pages as $page) {
                if ($page === 'ellipsis') {
                    if (end($normalized) !== 'ellipsis') {
                        $normalized[] = 'ellipsis';
                    }
                    continue;
                }

                if ($page >= 1 && $page <= $lastPage && !in_array($page, $normalized, true)) {
                    $normalized[] = $page;
                }
            }

            $pages = $normalized;
        }
    @endphp

    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($pages as $page)
                @if ($page === 'ellipsis')
                    <li class="page-item disabled page-ellipsis" aria-disabled="true">
                        <span class="page-link">…</span>
                    </li>
                @else
                    <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

