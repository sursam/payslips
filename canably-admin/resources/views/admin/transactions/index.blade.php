@extends('admin.layouts.app')

@section('content')
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">All Transactions</h1>
        </div>
    </div>
    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">All Transactions
                <span class="text-slate-400 font-medium">({{ $transactions->count() }})</span>
            </h2>
        </header>
        <div x-data="handleSelect">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full divide-y divide-slate-200 customdatatable">
                    <!-- Table header -->
                    <thead class="text-xs uppercase text-slate-500 bg-slate-50 border-t border-slate-200">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">SR. NO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">User</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Order</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Ammount</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Payment Status</div>
                            </th>
                            <th class="text-center px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap ">
                                <div class="font-semibold">Action</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm" x-data="{ open: false }">
                        @forelse($transactions as $transactionKey=>$transactionValue)
                            <!-- Row -->
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center text-slate-800">
                                        <div
                                            class="w-10 h-10 shrink-0 flex items-center justify-center bg-slate-100 rounded-full mr-2 sm:mr-3">
                                            <div class="font-medium text-sky-500">#{{ $transactionKey + 1 }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-sky-500">
                                        {{ $transactionValue->user->full_name }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-sky-500">
                                        @php
                                            $orderCount = $transactionValue->order?->details->count();
                                            $orderText = $transactionValue->order?->details->first()->product->name;
                                            if ($orderCount > 1) $orderText.= ' + ' . ($orderCount - 1);
                                        @endphp
                                        {{ $orderText }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-sky-500">
                                        {{ $transactionValue->ammount }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @switch($transactionValue->status)
                                        @case(1)
                                            <a href="javascript:void(0)" data-uuid="{{ $transactionValue->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5 ">Paid</a>
                                        @break

                                        @case(2)
                                            <a href="javascript:void(0)" data-uuid="{{ $transactionValue->uuid }}"
                                                class="inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-0.5">Failed</a>
                                        @break

                                        @default
                                            <a href="javascript:void(0)" data-uuid="{{ $transactionValue->uuid }}"
                                                class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5">Pending</a>
                                    @endswitch
                                </td>
                                <td
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap flex items-center justify-content-center">
                                    <div class="flex items-center text-center">
                                        <div class="m-1.5">
                                            <!-- Start -->
                                            <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                href="{{ route('admin.transaction.view', $transactionValue->uuid) }}">
                                                <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2 mt-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">

                                                    <g id="show-1" stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">

                                                        <g id="show-password" fill="black" fill-rule="nonzero">

                                                            <path
                                                                d="M9.952,0 C5.55581964,0.00248628109 1.60850854,2.69365447 0,6.785 C1.60695767,10.8762575 5.5544681,13.5668547 9.95,13.5668547 C14.3455319,13.5668547 18.2930423,10.8762575 19.9,6.785 C18.2920266,2.69501195 14.34672,0.00412882876 9.952,0 Z M9.952,11.309 C7.45401608,11.309 5.429,9.28398392 5.429,6.786 C5.429,4.28801608 7.45401608,2.263 9.952,2.263 C12.4499839,2.263 14.475,4.28801608 14.475,6.786 C14.4738964,9.28352664 12.4495266,11.3078964 9.952,11.309 L9.952,11.309 Z M9.952,4.07099704 C8.45309919,4.07099704 7.238,5.28609919 7.238,6.785 C7.238,8.28390081 8.45309919,9.499 9.952,9.499 C11.4509008,9.499 12.666003,8.28390081 12.666003,6.785 C12.6670637,6.06487688 12.3814668,5.37394216 11.8722623,4.86473767 C11.3630578,4.35553317 10.6721231,4.0699363 9.952,4.07099704 L9.952,4.07099704 Z"
                                                                id="Icon_material-remove-red-eye"></path>
                                                        </g>
                                                    </g>
                                                </svg>
                                                <span class="ml-2">View</span>
                                            </a>
                                            <!-- End -->
                                        </div>

                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-2 first:pl-5 last:pr-5 py-3 text-center whitespace-nowrap">No
                                        Transaction Yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @include('admin.layouts.paginate', ['paginatedCollection' => $transactions])
        </div>
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
