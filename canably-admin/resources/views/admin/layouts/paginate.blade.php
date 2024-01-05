@if ($paginatedCollection->hasPages())
    <div class="col-md-12 padding-x-reduce">
        <div class="c-custompagination">
            <nav class="pagination-nav d-flex justify-content-end">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <span class="page-link">Page</span>
                    </li>
                    @for ($i = 1; $i <= $paginatedCollection->lastPage(); $i++)
                        <li class="page-item">
                            <a class="page-link {{ $paginatedCollection->currentPage() == $i ? 'pe-none bg-slate-200' : '' }}"
                                href="{{ $paginatedCollection->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item disabled">
                        <span class="page-link">of</span>
                    </li>
                    <li class="page-item">
                        <span class="page-link">{{ $paginatedCollection->LastPage() }}</span>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endif
