@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/product.css') }}">
    <link href="{{ asset('assets/frontend/css/rating.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('admin.layouts.partials.page-title', [
        'html' => ['route' => route('admin.catalog.product.add'), 'text' => 'Add Product'],
    ])
    <!-- Page content -->
    <div
        class="flex flex-col space-y-10 sm:flex-row sm:space-x-6 sm:space-y-0 md:flex-col md:space-x-0 md:space-y-10 xl:flex-row xl:space-x-6 xl:space-y-0 mt-9">
        @include('admin.product.partials.product-sidebar')
        <!-- Add product button -->

        <!-- Content -->
        <div>
            @include('admin.product.partials.filters')
            <div id="productContainer">
                @include('admin.product.components.product', ['products' => $listProducts])
            </div>

            <div id="paginationContainer">
                {{ $listProducts->links()}}
                {{-- @include('admin.layouts.paginate',['paginatedCollection'=>$listProducts]) --}}
            </div>

        </div>
    </div>
    <x-product-images/>
@endsection

@push('scripts')
    <script>
        // A basic demo function to handle "select all" functionality
        document.addEventListener('alpine:init', () => {
            Alpine.data('handleSelect', () => ({
                selectall: false,
                selectAction() {
                    countEl = document.querySelector('.table-items-action');
                    if (!countEl) return;
                    checkboxes = document.querySelectorAll('input.table-item:checked');
                    document.querySelector('.table-items-count').innerHTML = checkboxes.length;
                    if (checkboxes.length > 0) {
                        countEl.classList.remove('hidden');
                    } else {
                        countEl.classList.add('hidden');
                    }
                },
                toggleAll() {
                    this.selectall = !this.selectall;
                    checkboxes = document.querySelectorAll('input.table-item');
                    [...checkboxes].map((el) => {
                        el.checked = this.selectall;
                    });
                    this.selectAction();
                },
                uncheckParent() {
                    this.selectall = false;
                    document.getElementById('parent-checkbox').checked = false;
                    this.selectAction();
                }
            }))
        })
    </script>
    <script src="{{ asset('assets/admin/js/product.js') }}"></script>
@endpush
