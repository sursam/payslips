@extends('customer.layouts.app', ['navbar' => true, 'sidebar' => true, 'footer' => false])
@push('style')
@endpush
@section('content')
    @php
        $details = $orderDetails->details;
        $grandTotal= $details->sum(function($details){
            return $details->quantity*$details->price;
        });
        $grandTotal+=$details->first()->shipping_cost;
        $grandTotal-= $orderDetails->discount ?? 0;
    @endphp
    <div id="Orders" class="w3-container city">
        <h2>Order Details</h2>

        <div class="track-butn">
            <a class="p-checkout default-button mt-3" href="javascript:void(0)" data-bs-toggle="modal"
                data-bs-target="#order-track-modal">
                <span>Track Order</span>
            </a>
        </div>

        <div class="all-order-box">
            <div class="all-order-box-top">
                <div class="row">
                    <div class="col-lg-3">
                        <h4>Order Id: <span>{{ $orderDetails->order_no }}</span></h4>
                    </div>
                    <div class="col-lg-3">
                        <h4>Order Amt:
                            <span>${{ number_format($grandTotal, 2) }}</span>
                        </h4>
                    </div>
                    <div class="col-lg-3">
                        <h4>Order Placed: <span>{{ formatTime($orderDetails->created_at) }}</span></h4>
                    </div>
                    <div class="col-lg-3">
                        <h4>Delivery Status:
                            <span>
                                @switch($orderDetails->delivery_status)
                                    @case(1)
                                        Packed
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
                                        Cancelled
                                    @break
                                    @case(6)
                                        Returned
                                    @break

                                    @default
                                        Confirmed
                                @endswitch
                            </span>
                        </h4>
                    </div>
                    {{-- <div class="col-lg-2">
                        @if ($orderDetails->delivery_type == 'delivery')
                            <h4>Ship To: <span>{{ $orderDetails->orderAddress?->shipper_name }}</span></h4>
                        @else
                            <h4><span>{{ $orderDetails->orderStore?->store?->name }}</span></h4>
                        @endif
                    </div> --}}
                </div>
            </div>
            <div class="all-order-box-butm all-order-box-butm-new">
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-2">
                        <h2>Shipping Address:</h2>
                        @if ($orderDetails->delivery_type == 'delivery')
                            @php
                                $shipperName= $orderDetails->orderAddress?->name;
                                $shipperContact= $orderDetails->orderAddress?->phone_number;
                                $orderAddress = $orderDetails->orderAddress?->full_address;
                                $address = '';
                            @endphp
                            @if (is_array($orderAddress))
                                @forelse ($orderAddress as $addressKey=>$addressValue)
                                    @php
                                        $address .= $addressValue . '</br>';
                                    @endphp
                                @empty
                                @endforelse
                            @endif
                            <p>
                                <b>Name:-</b> {{ $shipperName }}</br>
                                <b>Contact:-</b> {{ $shipperContact }}</br>
                                {!! $address !!}
                            </p>
                        @else
                            <p>
                                {{ $orderDetails->orderStore?->store?->name }}
                                {!! $orderDetails->orderStore?->store?->full_address !!}
                            </p>
                        @endif

                    </div>
                    <div class="col-lg-4 col-sm-4 col-12">
                        <h2>Payment Method</h2>
                        <p><span></span>Card payment</p>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-12">
                        <h2>Order Summary</h2>
                        <p class="fw-bold">Items:
                        <div class="d-flex flex-column">
                            @forelse ($details as $detail)
                                <span>{{ $detail->quantity }} X ${{ $detail->price }}</span>
                            @empty
                            @endforelse
                        </div>
                        </p>
                        <p class="fw-bold">Shipping Flat Rate:
                            <span> ${{ $details->first()->shipping_cost }} </span>
                        </p>
                        <p class="fw-bold">Tax:
                            <span> ${{ 0 }} </span>
                        </p>

                        <p class="fw-bold">Discount:
                            <span>
                                ${{ $orderDetails->discount ?? 0 }}
                            </span>
                        </p>
                        <p class="fw-bold">Grand Total:
                            <span>
                                ${{ number_format($grandTotal, 2) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            @include('customer.order.component.order-details-box', ['products' => $details])

        </div>
    </div>
    <!-- Modal -->
    @include('modals.order-track-modal')
@endsection
@push('scripts')
@endpush
