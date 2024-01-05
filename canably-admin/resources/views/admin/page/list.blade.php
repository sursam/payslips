@extends('admin.layouts.app')

@section('content1')
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        @include('admin.layouts.partials.page-title')
        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Add customer button -->
            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <a href="{{ route('admin.page.add') }}"><span class="hidden xs:block ml-2">Add Page</span></a>
            </button>
        </div>
    </div>
    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <div x-data="handleSelect">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table table-striped table-hover table-responsive">
                    <thead>
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Name</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Title</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Slug</div>
                            </th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200">
                        @forelse ($listPages as $page)
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ $page->name }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ $page->title }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ $page->slug }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">
                                        @switch($page->is_active)
                                            @case(1)
                                                <a href="javascript:void(0)" data-value="0" data-table="pages" data-message="inactive" data-uuid="{{ $page->uuid }}" class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5 changeStatus">Active</a>
                                                @break
                                            @case(0)
                                                <a href="javascript:void(0)" data-value="1" data-uuid="{{ $page->uuid }}" data-table="pages" data-message="active" class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5 changeStatus">Inactive</a>
                                                @break
                                            @default
                                                <a href="javascript:void(0)" class="inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-0.5">Deleted</a>
                                        @endswitch
                                    </div>
                                </td>
                                <td>
                                    <div class="col">
                                        <a href="{{ route('admin.page.edit', $page->uuid) }}"
                                            class="btn btn-mini mergin_one">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('{{ trans('labels.32') }}');"
                                            href="{{ route('admin.page.delete', $page->uuid) }}" class="btn btn-mini">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"></td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>

                        </thead>
                </table>
            </div>

        </div>
    </div>
    <!-- Pagination -->
    {{-- <div class="mt-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            {{ $listCategories->links() }}
        </div>
    </div> --}}
@endsection
@section('content')
@include('admin.layouts.partials.page-title',['html'=>['route'=>route('admin.page.add'),'text'=>'Add Page']])
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">{{ $pageTitle }} <span class="text-slate-400 font-medium">({{ $listPages->count() }})</span></h2>
        </header>
        <div x-data="handleSelect">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full customdatatable">
                    <!-- Table header -->
                    <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Name</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Title</div>
                            </th>
                            <th class="text-center px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Status</div>
                            </th>
                            <th class="text-center px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold">Action</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->
                        @forelse ($listPages as $page)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{ $page->name }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800">{{ $page->title }}</div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">
                                    @switch($page->status)
                                    @case(1)
                                        <a href="javascript:void(0)" data-value="0" data-table="pages" data-message="inactive" data-uuid="{{ $page->uuid }}" class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5 changeStatus">Active</a>
                                        @break
                                    @case(0)
                                        <a href="javascript:void(0)" data-value="1" data-uuid="{{ $page->uuid }}" data-table="pages" data-message="active" class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5 changeStatus">Inactive</a>
                                        @break
                                    @default
                                        <a href="javascript:void(0)" class="inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-0.5">Deleted</a>
                                @endswitch



                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap ">
                                <div class="flex items-center justify-content-center">
                                    <div class="m-1.5">
                                        <!-- Start -->
                                        <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600" href="{{ route('admin.page.edit', $page->uuid) }}">
                                            <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                                <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                                            </svg>
                                            <span class="ml-2">Edit</span>
                                        </a>
                                        <!-- End -->
                                    </div>
                                    <div class="m-1.5">
                                        <!-- Start -->
                                        <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-rose-500 deleteData" data-table="pages" data-uuid="{{ $page->uuid }}" href="javascript:void(0)">
                                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                                <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                                            </svg>
                                            <span class="ml-2">Delete</span>
                                        </a>
                                        <!-- End -->
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="6">
                                Sorry No Data Yet
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <!-- Pagination -->
    @include('admin.layouts.paginate',['paginatedCollection'=>$listPages])
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
@endpush
