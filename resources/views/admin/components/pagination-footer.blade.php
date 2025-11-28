@php
    $paginatorInstance = $collection ?? null;
@endphp

@if ($paginatorInstance instanceof \Illuminate\Contracts\Pagination\Paginator)
    @php
        $isLengthAware = $paginatorInstance instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;
        $first = $paginatorInstance->firstItem() ?? ($paginatorInstance->count() ? 1 : 0);
        $last = $paginatorInstance->lastItem() ?? $paginatorInstance->count();
        $total = $isLengthAware ? $paginatorInstance->total() : $paginatorInstance->count();
        $summaryFormat = $summaryFormat ?? 'Showing :first to :last of :total entries';
        $replacements = [
            ':first' => number_format($first),
            ':last' => number_format($last),
            ':total' => number_format($total),
            ':count' => number_format($paginatorInstance->count()),
        ];
        $summaryText = strtr($summaryFormat, $replacements);
        $appends = $appends ?? request()->except('page');
    @endphp

    <div class="row mt-4 pagination-footer-row">
        <div class="col-sm-6">
            <p class="mb-sm-0">{{ $summaryText }}</p>
        </div>
        <div class="col-sm-6">
            <div class="pagination-footer-row__nav">
                {{ $paginatorInstance->appends($appends)->links() }}
            </div>
        </div>
    </div>
@endif

