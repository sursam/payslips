@extends('admin.layouts.app')
@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('content')
    <!-- Page header -->
    {{-- @include('admin.layouts.partials.page-title',['html'=>['route'=>route('admin.delivery.agent.add'),'text'=>'Add Agent']]) --}}

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">All Orders
                <span class="text-slate-400 font-medium">({{ $orders->count() }})</span>
            </h2>
        </header>
        <div x-data="handleSelect">

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full divide-y divide-slate-200 customdatatable">
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
                                <div class="font-semibold text-left">Order Id</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Customer Details</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Order Details</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Order Type</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Order Amount</div>
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
                        {{-- {{--  @php
                            $i = 0;
                        @endphp --}}
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">{{ $order->order_no }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">
                                        <p>
                                            <span class="fw-bold">Name:- </span>
                                            @if ($order->delivery_type == 'delivery')
                                                {{ $order->orderAddress?->name }}
                                            @else
                                                {{ $order->orderStore?->store?->name }}
                                            @endif
                                        </p>
                                        <p>
                                            <span class="fw-bold">Email:- </span>
                                            {{ $order->user->email }}
                                        </p>
                                        <p>
                                            <span class="fw-bold">Contact:- </span>
                                            @if ($order->delivery_type == 'delivery')
                                                {{ $order->orderAddress?->phone_number }}
                                            @else
                                                {{ $order->orderStore?->store?->phone_number }}
                                            @endif

                                        </p>

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 w-50">
                                    <div class="font-medium text-slate-800">
                                        <p>
                                            <span class="fw-bold">Total Products:- </span>
                                            {{ $order->details->count() }}
                                        </p>
                                        <p>
                                            <span class="fw-bold">Address:- </span>
                                            @if ($order->delivery_type == 'delivery')
                                                @php
                                                    $address = $order->orderAddress;
                                                    $fullAddress = $address->full_address;
                                                    $implode = collect($fullAddress)->implode(', ');
                                                @endphp
                                                {{ $implode }}
                                            @else
                                                @php
                                                    $fullAddress = strip_tags($order->orderStore?->store?->full_address);
                                                @endphp
                                                {{ $fullAddress }}
                                            @endif
                                        </p>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">
                                        {{ $order->delivery_type == 'delivery' ? 'Delivery' : 'Store Pickup' }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">
                                        @php
                                            $grandTotal = $order->details->sum(function ($details) {
                                                return $details->quantity * $details->price;
                                            });
                                            $grandTotal += $order->details->first()?->shipping_cost;
                                            $grandTotal-=$order->discount ?? 0;
                                        @endphp
                                        ${{ $grandTotal }}
                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @switch($order->delivery_status)
                                        @case(1)
                                            <a href="javascript:void(0)" data-uuid="{{ $order->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5">
                                                Agent Assigned
                                            </a>
                                        @break

                                        @case(2)
                                            <a href="javascript:void(0)" data-uuid="{{ $order->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5">
                                                Shipped
                                            </a>
                                        @break

                                        @case(3)
                                            <a href="javascript:void(0)" data-uuid="{{ $order->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5">
                                                Out for delivery
                                            </a>
                                        @break

                                        @case(4)
                                            <a href="javascript:void(0)" data-uuid="{{ $order->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5">
                                                Delivered
                                            </a>
                                        @break

                                        @case(5)
                                            <a href="javascript:void(0)" data-uuid="{{ $order->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5">
                                                Returned
                                            </a>
                                        @break

                                        @case(6)
                                            <a href="javascript:void(0)" data-uuid="{{ $order->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5">
                                                Cancelled
                                            </a>
                                        @break

                                        @default
                                            <a href="javascript:void(0)" data-uuid="{{ $order->uuid }}"
                                                class="inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-0.5">
                                                Order Placed
                                            </a>
                                    @endswitch
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap ">
                                    <div class="flex items-center text-center">
                                        <div class="m-1.5">
                                            <!-- Start -->
                                            <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                href="{{ route('admin.order.view', $order->uuid) }}">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4 h-4 fill-current text-slate-500 shrink-0"
                                                    viewBox="0 0 24 22">
                                                    <path
                                                        d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z" />
                                                </svg>
                                                <span class="ml-2">View</span>
                                            </a>
                                            <!-- End -->
                                        </div>
                                        @if ($order->delivery_type == 'delivery')
                                            <div class="m-1.5">
                                                <!-- Start -->
                                                <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                    href="{{ route('admin.inventory.delivery.edit', $order->uuid) }}">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 fill-current text-slate-500 shrink-0"
                                                        viewBox="0 0 24 22">
                                                        <path
                                                            d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z" />
                                                    </svg>
                                                    <span class="ml-2">Assign Order</span>
                                                </a>
                                                <!-- End -->
                                            </div>
                                        @endif

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
        </div>
        @include('admin.layouts.paginate', ['paginatedCollection' => $orders])
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
