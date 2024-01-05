@forelse ($orders as $order)
    @php
        $details= $order->details;
        $grandTotal= $details->sum(function($details){
            return $details->quantity*$details->price;
        });
        $grandTotal+=$details->first()?->shipping_cost;
        $grandTotal-=$order->discount ?? 0;
        $count = $order->details->count();
    @endphp
    <div class="all-order-box">
        <div class="all-order-box-top">
            <div class="row">
                <div class="col-lg-3">
                    <h4>Order Id: <span class="text-small">#{{ $order->order_no }}</span></h4>
                </div>
                <div class="col-lg-3">
                    <h4>Order Amt:
                        <span>${{ number_format($grandTotal,2) }}</span>
                    </h4>
                </div>
                <div class="col-lg-3">
                    <h4>Order Placed: <span>{{ formatTime($order->created_at) }}</span></h4>
                </div>
                <div class="col-lg-3">
                    <h4>Order Delivered:
                        <span>
                            @switch($order->delivery_status)
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
                    @if ( $order->delivery_type== 'store_pick')
                        @php
                             $shipperName= $order->orderStore?->store?->name
                        @endphp
                    @else
                        @php
                            $shipperName= $order->orderAddress?->shipper_name;
                        @endphp
                    @endif
                    <h4>Ship To: <span>{{ $shipperName }}</span></h4>
                </div> --}}
            </div>
        </div>
        <div class="all-order-box-butm">
            <div class="row">
                <div class="col-lg-2 col-sm-2 col-2">
                    <div class="all-order-box-butm-img">
                        {{-- {{ Log::info($details->first()?->product?->latest_image); }} --}}
                        <img src="{{ $details->first()?->product?->latest_image }}" alt="">
                        {{-- <img src="{{ $details?->product?->latest_image }}" alt=""> --}}
                    </div>
                </div>
                <div class="col-lg-5 col-sm-5 col-12">
                    <div class="all-order-box-butm-text">
                        <h3>{{ $details->first()?->product?->name }}</h3>
                        @if ($count > 1)
                            <p>+ {{ $count - 1 }} items</p>
                        @endif

                    </div>
                </div>
                <div class="col-lg-5 col-sm-5 col-12">
                    <div class="all-order-box-butm-butn">
                        <a class="apply-coupon default-button" href="javascript:void(0)"><span>Write A Review</span></a>
                        <a class="p-checkout default-button mt-3" href="{{ route('customer.order.details', $order->uuid) }}"><span>View Order Details</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
        No Data Found
    @endforelse
