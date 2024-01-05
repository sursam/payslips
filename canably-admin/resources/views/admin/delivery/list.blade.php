@extends('admin.layouts.app')
@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('content')
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">All Deliveries <span
                    class="text-slate-400 font-medium">({{ $orders->count() }})</span></h2>
        </header>
        <div x-data="handleSelect">

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full divide-y divide-slate-200 customdatatable" aria-describedby="table">
                    <!-- Table header -->
                    <thead class="text-xs uppercase text-slate-500 bg-slate-50 border-t border-slate-200">
                        <tr>
                            {{-- <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                            <div class="flex items-center">
                                <label class="inline-flex">
                                    <span class="sr-only">Select all</span>
                                    <input id="parent-checkbox" class="form-checkbox" type="checkbox" @click="toggleAll" />
                                </label>
                            </div>
                        </th> --}}
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Image</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Name</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Email</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Phone</div>
                            </th>

                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Status</div>
                            </th>
                            <th class="text-center px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap ">
                                <div class="font-semibold">Action</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm" x-data="{ open: false }">

                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center text-slate-800">
                                        <div class="font-medium text-sky-500">#{{ $order->order_no }}</div>
                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">{{ $order->user->fullName }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">{{ $order->user->mobile_number }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @switch($order->delivery_status)
                                        @case(0)
                                            <a href="javascript:void(0)" data-value="1" data-uuid="{{ $order->uuid }}"
                                                data-table="users" data-message="active"
                                                class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5">Confirmed</a>
                                        @break
                                        @case(1)
                                            <a href="javascript:void(0)" data-value="0" data-table="users" data-message="inactive"
                                                data-uuid="{{ $order->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5 changeUserStatus">Packed & Assigned</a>
                                        @break
                                        @case(2)
                                            <a href="javascript:void(0)" data-value="1" data-uuid="{{ $order->uuid }}"
                                                data-table="users" data-message="active"
                                                class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5">Shipped</a>
                                        @break

                                        @case(3)
                                            <a href="javascript:void(0)" data-value="1" data-uuid="{{ $order->uuid }}"
                                                data-table="users" data-message="active"
                                                class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5">Out For Delivery</a>
                                        @break

                                        @case(4)
                                            <a href="javascript:void(0)" data-value="1" data-uuid="{{ $order->uuid }}"
                                                data-table="users" data-message="active"
                                                class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5">Delivered</a>
                                        @break
                                        @case(5)
                                            <a href="javascript:void(0)" data-value="1" data-uuid="{{ $order->uuid }}"
                                                data-table="users" data-message="active"
                                                class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5">Returned</a>
                                        @case(6)
                                            <a href="javascript:void(0)" data-value="1" data-uuid="{{ $order->uuid }}"
                                                data-table="users" data-message="active"
                                                class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5">Cancelled/Rejected</a>
                                        @break
                                    @endswitch
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap ">
                                    <div class="flex items-center text-center">
                                        <div class="m-1.5">
                                            <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                href="{{ route('admin.inventory.delivery.edit', $order->uuid) }}">
                                                <svg class="w-4 h-4 fill-current text-slate-500 shrink-0"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                                                </svg>
                                                <span class="ml-2">Change Status</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Data Yet</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
            @include('admin.layouts.paginate', ['paginatedCollection' => $orders])
        </div>
    </div>
    @endsection
    @push('scripts')
    @endpush
