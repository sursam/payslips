@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/order.css') }}">
@endpush
@section('content')
    @php
        $detailedStatus = collect($order->status_description);
    @endphp
    <div class="container padding-bottom-3x mb-1">
        <div class="card mb-3">
            <div class="p-4 text-center text-white text-lg bg-dark rounded-top">
                <span class="text-uppercase">Tracking Order No - </span>
                <span class="text-medium">{{ $order->order_no }}</span>
            </div>
            <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
                <div class="w-100 text-center py-1 px-2"><span class="text-medium fw-bold">Ordered At:</span>
                    {{ \Carbon\Carbon::parse($order->created_at)->format('M d , Y \\a\\t\\ H:i:s') }}</div>
                <div class="w-100 text-center py-1 px-2"><span class="text-medium fw-bold">Address:</span>
                    {{ implode(',',$order->orderAddress->full_address) }}
                </div>
                <div class="w-100 text-center py-1 px-2"><span class="text-medium fw-bold">Expected Date:</span>{{ \Carbon\Carbon::parse($order->delivered_at)->format('M d , Y ') }}</div>
            </div>
            <div class="card-body">
                <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">

                    <div class="step @if ($order->delivery_status >= 0) completed @endif">
                        <div class="step-icon-wrap">
                            <div class="step-icon"><i class="pe-7s-cart"></i></div>
                        </div>
                        <h4 class="step-title">Confirmed Order</h4>
                        @if ($order->delivery_status >= 0 && $detailedStatus->isNotEmpty() && $detailedStatus->has('confirmed'))
                            <h5>at</h5>
                            <h4 class="step-title">{{ $detailedStatus['confirmed']['time'] }}</h4>
                        @endif
                    </div>

                    <div class="step @if ($order->delivery_status >= 1) completed @endif">
                        <button class="step-icon-wrap @if ($order->delivery_status == 0) assignAgent @endif" @if ($order->delivery_status == 0) aria-controls="assignAgentModal" data-bs-toggle="modal" data-bs-target="#assignAgentModal" @endif>
                            <div class="step-icon"><i class="pe-7s-add-user"></i></div>
                        </button>
                        <h4 class="step-title">Packed & Assigned</h4>
                        @if (
                            $order->delivery_status >= 1 &&
                                $detailedStatus->isNotEmpty() &&
                                $detailedStatus->has('packed'))
                                <h5>at</h5>
                            <h4 class="step-title">{{ $detailedStatus['packed']['time'] }}</h4>
                        @endif
                    </div>

                    <div class="step @if ($order->delivery_status >= 2) completed @endif">
                        <div class="step-icon-wrap">
                            <div class="step-icon"><i class="fas fa-shipping-fast"></i></div>
                        </div>
                        <h4 class="step-title">Shipped</h4>
                        @if (
                            $order->delivery_status >= 2 &&
                                $detailedStatus->isNotEmpty() &&
                                $detailedStatus->has('shipped'))
                            <h4 class="step-title">{{ $detailedStatus['shipped']['time'] }}</h4>
                        @endif
                    </div>

                    <div class="step @if ($order->delivery_status >= 3) completed @endif">
                        <div class="step-icon-wrap">
                            <div class="step-icon"><i class="pe-7s-car"></i></div>
                        </div>
                        <h4 class="step-title">Out For Delivery</h4>
                        @if (
                            $order->delivery_status >= 3 &&
                                $detailedStatus->isNotEmpty() &&
                                $detailedStatus->has('outfordelivery'))
                            <h4 class="step-title">{{ $detailedStatus['outfordelivery']['time'] }}</h4>
                        @endif
                    </div>

                    <div class="step @if ($order->delivery_status >= 4) completed @endif">
                        <div class="step-icon-wrap">
                            <div class="step-icon"><i class="pe-7s-home"></i></div>
                        </div>
                        <h4 class="step-title">Delivered</h4>
                        @if (
                            $order->delivery_status >= 4 &&
                                $detailedStatus->isNotEmpty() &&
                                $detailedStatus->has('delivered'))
                            <h4 class="step-title">{{ $detailedStatus['delivered']['time'] }}</h4>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    @if ($order->delivery_status == 0)
        <x-modals.assign-agent :agents="$agents" :detailedStatus="$detailedStatus" :order="$order" />
    @endif
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/submit.js') }}"></script>
@endpush
