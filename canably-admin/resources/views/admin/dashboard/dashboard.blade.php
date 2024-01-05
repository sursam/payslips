@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
    @include('admin.layouts.partials.welcome')
    <!-- Cards -->
    <div class="grid grid-cols-12 gap-6">

        <!-- Line chart (Canably Plus) -->
        <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
            <div class="px-5 pt-5">
                <h2 class="text-lg font-semibold text-slate-800 mb-2">Total Order Value</h2>
                <div class="text-xs font-semibold text-slate-400 uppercase mb-1">This month</div>
                <div class="flex items-start">
                    <div class="text-3xl font-bold text-slate-800 mr-2">$24,780</div>
                    <div class="text-sm font-semibold text-white px-1.5 bg-emerald-500 rounded-full">+49%</div>
                </div>
            </div>
            <!-- Chart built with Chart.js 3 -->
            <!-- Check out src/js/components/dashboard-card-01.js for config -->

        </div>

        <!-- Line chart (Canably Advanced) -->
        <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
            <div class="px-5 pt-5">
                <h2 class="text-lg font-semibold text-slate-800 mb-2">Avarage Order Value</h2>
                <div class="text-xs font-semibold text-slate-400 uppercase mb-1">This month</div>
                <div class="flex items-start">
                    <div class="text-3xl font-bold text-slate-800 mr-2">$17,489</div>
                    <div class="text-sm font-semibold text-white px-1.5 bg-amber-500 rounded-full">-14%</div>
                </div>
            </div>
            <!-- Chart built with Chart.js 3 -->
            <!-- Check out src/js/components/dashboard-card-01.js for config -->

        </div>

        <!-- Line chart (Canably Plus) -->
        <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
            <div class="px-5 pt-5 pb-5">
                <h2 class="text-lg font-semibold text-slate-800 mb-2">Total Revenue</h2>
                <div class="text-xs font-semibold text-slate-400 uppercase mb-1">This month</div>
                <div class="flex items-start">
                    <div class="text-3xl font-bold text-slate-800 mr-2">$24,780</div>
                    <div class="text-sm font-semibold text-white px-1.5 bg-emerald-500 rounded-full">+49%</div>
                </div>
            </div>
            <!-- Chart built with Chart.js 3 -->
            <!-- Check out src/js/components/dashboard-card-01.js for config -->

        </div>

        <!-- Line chart (Real Time Value) -->
        <div class="flex flex-col col-span-full sm:col-span-12 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100 sm:flex sm:justify-between sm:items-center">
                <div class="d-flex">
                    <h2 class="font-semibold text-slate-800">Monthly Revenue</h2>
                    <div class="relative ml-2" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="block" aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                            @focusout="open = false" @click.prevent>
                            <svg class="w-4 h-4 fill-current text-slate-400" viewBox="0 0 16 16">
                                <path
                                    d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                            </svg>
                        </button>
                        <div class="z-10 absolute bottom-full left-1/2 -translate-x-1/2">
                            <div class="bg-white border border-slate-200 p-3 rounded shadow-lg overflow-hidden mb-2"
                                x-show="open" x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0" x-cloak>
                                <div class="text-xs text-center whitespace-nowrap">Built with <a class="underline"
                                        @focus="open = true" @focusout="open = false" href="https://www.chartjs.org/"
                                        target="_blank">Chart.js</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                    <!-- Dropdown -->
                    <div class="relative" x-data="{ open: false, selected: 2 }">
                        <button
                            class="btn justify-between min-w-44 bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600"
                            aria-label="Select date range" aria-haspopup="true" @click.prevent="open = !open"
                            :aria-expanded="open" aria-expanded="false">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 fill-current text-slate-500 shrink-0 mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z">
                                    </path>
                                </svg>
                                <span x-text="$refs.options.children[selected].children[1].innerHTML">Last Month</span>
                            </span>
                            <svg class="shrink-0 ml-1 fill-current text-slate-400" width="11" height="7"
                                viewBox="0 0 11 7">
                                <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z"></path>
                            </svg>
                        </button>
                        <div class="z-10 absolute top-full right-0 w-full bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                            @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                            x-transition:enter="transition ease-out duration-100 transform"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" style="display: none;">
                            <div class="font-medium text-sm text-slate-600" x-ref="options">
                                <button tabindex="0"
                                    class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                                    :class="selected === 0 & amp; & amp;
                                    'text-indigo-500'"
                                    @click="selected = 0;open = false" @focus="open = true" @focusout="open = false">
                                    <svg class="shrink-0 mr-2 fill-current text-indigo-500 invisible"
                                        :class="selected !== 0 & amp; & amp;
                                        'invisible'"
                                        width="12" height="9" viewBox="0 0 12 9">
                                        <path
                                            d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z">
                                        </path>
                                    </svg>
                                    <span>Today</span>
                                </button>
                                <button tabindex="0"
                                    class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                                    :class="selected === 1 & amp; & amp;
                                    'text-indigo-500'"
                                    @click="selected = 1;open = false" @focus="open = true" @focusout="open = false">
                                    <svg class="shrink-0 mr-2 fill-current text-indigo-500 invisible"
                                        :class="selected !== 1 & amp; & amp;
                                        'invisible'"
                                        width="12" height="9" viewBox="0 0 12 9">
                                        <path
                                            d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z">
                                        </path>
                                    </svg>
                                    <span>Last 7 Days</span>
                                </button>
                                <button tabindex="0"
                                    class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer text-indigo-500"
                                    :class="selected === 2 & amp; & amp;
                                    'text-indigo-500'"
                                    @click="selected = 2;open = false" @focus="open = true" @focusout="open = false">
                                    <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                        :class="selected !== 2 & amp; & amp;
                                        'invisible'"
                                        width="12" height="9" viewBox="0 0 12 9">
                                        <path
                                            d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z">
                                        </path>
                                    </svg>
                                    <span>Last Month</span>
                                </button>
                                <button tabindex="0"
                                    class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                                    :class="selected === 3 & amp; & amp;
                                    'text-indigo-500'"
                                    @click="selected = 3;open = false" @focus="open = true" @focusout="open = false">
                                    <svg class="shrink-0 mr-2 fill-current text-indigo-500 invisible"
                                        :class="selected !== 3 & amp; & amp;
                                        'invisible'"
                                        width="12" height="9" viewBox="0 0 12 9">
                                        <path
                                            d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z">
                                        </path>
                                    </svg>
                                    <span>Last 12 Months</span>
                                </button>
                                <button tabindex="0"
                                    class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                                    :class="selected === 4 & amp; & amp;
                                    'text-indigo-500'"
                                    @click="selected = 4;open = false" @focus="open = true" @focusout="open = false">
                                    <svg class="shrink-0 mr-2 fill-current text-indigo-500 invisible"
                                        :class="selected !== 4 & amp; & amp;
                                        'invisible'"
                                        width="12" height="9" viewBox="0 0 12 9">
                                        <path
                                            d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z">
                                        </path>
                                    </svg>
                                    <span>All Time</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Chart built with Chart.js 3 -->
            <!-- Check out src/js/components/dashboard-card-05.js for config -->
            <div class="px-5 py-3">
                <div class="flex items-start">
                    <div class="text-3xl font-bold text-slate-800 mr-2 tabular-nums">$<span
                            id="dashboard-card-08-value">57.81</span></div>
                    <div id="dashboard-card-08-deviation" class="text-sm font-semibold text-white px-1.5 rounded-full">
                    </div>
                </div>
            </div>
            <div class="grow">
                <!-- Change the height attribute to adjust the chart height -->
                <canvas id="dashboard-card-08" width="595" height="248"></canvas>
            </div>
        </div>

        <!-- Table (Top Customers) -->
        <div class="col-span-full xl:col-span-6  bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Recent Customers</h2>
            </header>
            <div class="p-3">

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-sm">
                        <!-- Table header -->
                        <thead class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm">
                            <tr>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Name</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Email</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Status</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Created At</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm font-medium divide-y divide-slate-100">
                            <!-- Row -->
                            @forelse ($customers as $customer)
                                <tr>
                                    <td class="p-2 text-sm">
                                        <div class="flex items-center">
                                            {{--  <img class="rounded-full" src="{{ asset('assets/images/dummy-user.png') }}"
                                            width="20" height="18" alt="User upload" /> --}}
                                            <div class="text-slate-800">
                                                {{ $customer->fullName ? $customer->fullName : '---' }}</div>
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center">{{ $customer->email }}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center text-emerald-500">
                                            {{ $customer->is_active == 1 ? 'Active' : 'Inactive' }}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center">{{ date('j F, Y', strtotime($customer->created_at)) }}
                                        </div>
                                    </td>

                                </tr>
                                <!-- Row -->
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Data Yet</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- Table (Top Sellers) -->
        <div class="col-span-full xl:col-span-6  bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Recent Orders</h2>
            </header>
            <div class="p-3">

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <!-- Table header -->
                        <thead class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm">
                            <tr>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Order Id</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Amount</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Status</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">Ordered At</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm font-medium divide-y divide-slate-100">
                            <!-- Row -->
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="p-2">
                                        <div class="flex items-center">
                                            {{-- <svg class="shrink-0 mr-2 sm:mr-3" width="36" height="36"
                                            viewBox="0 0 36 36">
                                            <circle fill="#24292E" cx="18" cy="18" r="18" />
                                            <path
                                                d="M18 10.2c-4.4 0-8 3.6-8 8 0 3.5 2.3 6.5 5.5 7.6.4.1.5-.2.5-.4V24c-2.2.5-2.7-1-2.7-1-.4-.9-.9-1.2-.9-1.2-.7-.5.1-.5.1-.5.8.1 1.2.8 1.2.8.7 1.3 1.9.9 2.3.7.1-.5.3-.9.5-1.1-1.8-.2-3.6-.9-3.6-4 0-.9.3-1.6.8-2.1-.1-.2-.4-1 .1-2.1 0 0 .7-.2 2.2.8.6-.2 1.3-.3 2-.3s1.4.1 2 .3c1.5-1 2.2-.8 2.2-.8.4 1.1.2 1.9.1 2.1.5.6.8 1.3.8 2.1 0 3.1-1.9 3.7-3.7 3.9.3.4.6.9.6 1.6v2.2c0 .2.1.5.6.4 3.2-1.1 5.5-4.1 5.5-7.6-.1-4.4-3.7-8-8.1-8z"
                                                fill="#FFF" />
                                        </svg> --}}
                                            <div class="text-slate-800">#{{ $loop->iteration }}</div>
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        @php
                                            $details = $order->details;
                                            $total = $order->details->sum(function ($details) {
                                                return $details->price * $details->quantity;
                                            });
                                            $total -= $order->discount ?? 0;
                                        @endphp

                                        <div class="text-center">{{ $total }}<span>$</span></div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center text-emerald-500">
                                            @switch($order->delivery_status)
                                                @case(1)
                                                    Agent Assigned
                                                @break

                                                @case(2)
                                                    Shipped
                                                @break

                                                @case(3)
                                                    Out for delivery
                                                @break

                                                @case(4)
                                                    Delivered
                                                @break

                                                @case(5)
                                                    Returned
                                                @break

                                                @case(6)
                                                    Cancelled
                                                @break

                                                @default
                                                    Order Placed
                                            @endswitch
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center">{{ $order->created_at->format('jS F , Y') }}</div>
                                    </td>

                                </tr>
                                @empty
                                    <td colspan="4">No orders yet</td>
                                @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!-- Table (Top Sellers) -->
            <div class="col-span-full xl:col-span-12  bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800">Recent Sellers</h2>
                </header>
                <div class="p-3">

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <!-- Table header -->
                            <thead class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Name</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Email</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Status</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Created At</div>
                                    </th>

                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="text-sm font-medium divide-y divide-slate-100">
                                <!-- Row -->
                                @forelse ($sellers as $seller)
                                    <tr>
                                        <td class="p-2">
                                            <div class="flex items-center">
                                                {{--  <svg class="shrink-0 mr-2 sm:mr-3" width="36" height="36"
                                            viewBox="0 0 36 36">
                                            <circle fill="#24292E" cx="18" cy="18" r="18" />
                                            <path
                                                d="M18 10.2c-4.4 0-8 3.6-8 8 0 3.5 2.3 6.5 5.5 7.6.4.1.5-.2.5-.4V24c-2.2.5-2.7-1-2.7-1-.4-.9-.9-1.2-.9-1.2-.7-.5.1-.5.1-.5.8.1 1.2.8 1.2.8.7 1.3 1.9.9 2.3.7.1-.5.3-.9.5-1.1-1.8-.2-3.6-.9-3.6-4 0-.9.3-1.6.8-2.1-.1-.2-.4-1 .1-2.1 0 0 .7-.2 2.2.8.6-.2 1.3-.3 2-.3s1.4.1 2 .3c1.5-1 2.2-.8 2.2-.8.4 1.1.2 1.9.1 2.1.5.6.8 1.3.8 2.1 0 3.1-1.9 3.7-3.7 3.9.3.4.6.9.6 1.6v2.2c0 .2.1.5.6.4 3.2-1.1 5.5-4.1 5.5-7.6-.1-4.4-3.7-8-8.1-8z"
                                                fill="#FFF" />
                                        </svg> --}}
                                                <div class="text-slate-800">{{ $seller->fullName ? $seller->fullName : '---' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-2">
                                            <div class="text-center">{{ $seller->email }}</div>
                                        </td>
                                        <td class="p-2">
                                            <div class="text-center text-emerald-500">
                                                {{ $seller->is_active == 1 ? 'Active' : 'Inactive' }}</div>
                                        </td>
                                        <td class="p-2">
                                            <div class="text-center">{{ date('j F, Y', strtotime($seller->created_at)) }}</div>
                                        </td>

                                    </tr>
                                    <!-- Row -->
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No Data Yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


        </div>
    @endsection
    @push('scripts')
    @endpush
