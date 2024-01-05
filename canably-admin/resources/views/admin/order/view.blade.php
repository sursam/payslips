@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/customer.css') }}">
@endpush
@section('content')
    @php
        $details = $order->details;
        $grandTotal = $details->sum(function ($details) {
            return $details->quantity * $details->price;
        });
        $grandTotal += $details->first()?->shipping_cost;
        $grandTotal-=$order->discount ?? 0;
    @endphp
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200">
            <form method="post">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="form_field">
                        <h2 class="text-xl text-slate-800 font-bold mb-6">Order Information</h2>
                        <div class="grid gap-2 md:grid-cols-2 ">
                            <div class="d-flex">
                                <h4 class="fw-bold">Order Id: </h4>
                                <span class="text-small">#{{ $order->order_no }}</span>
                            </div>
                            <div class="d-flex">
                                <h4 class="fw-bold">Order Amt:</h4>
                                <span>${{ $grandTotal }}</span>
                                <h4 class="fw-bold">Order Discount:</h4>
                                <span>${{ $order->discount ?? 0 }}</span>
                            </div>
                            <div class="d-flex">
                                <h4 class="fw-bold">Order Placed: </h4>
                                <span>{{ formatTime($order->created_at) }}</span>
                            </div>
                            <div class="d-flex">
                                <h4 class="fw-bold">Order Status: </h4>
                                <span>
                                    @switch($order->delivery_status)
                                        @case(1)
                                            Delivered
                                        @break

                                        @case(2)
                                            Cancelled
                                        @break

                                        @case(3)
                                            Returned
                                        @break

                                        @default
                                            Pending
                                    @endswitch
                                </span>
                            </div>
                            <div class="d-flex">
                                <h4 class="fw-bold">Contact:-- </h4>

                                @if ($order->delivery_type == 'delivery')
                                    <span>{{ $order->orderAddress?->phone_number }}</span>
                                @else
                                    <span>{{ $order->orderStore?->store?->phone_number }}</span>
                                @endif

                            </div>

                            <div class=" d-flex">
                                <div>
                                    <h2>Order Summary</h2>
                                </div>
                                <br>
                                <div>
                                    <p class="fw-bold">Items:
                                    <div class="d-flex flex-column">
                                        @forelse ($details as $detail)
                                            <span>{{ $detail->quantity }} X ${{ $detail->price }}</span>
                                        @empty
                                        @endforelse
                                    </div>
                                    </p>
                                </div>
                                <div>
                                    <p class="fw-bold">Shipping Flat Rate:
                                        <span> ${{ $details->sum('shipping_cost') }} </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="fw-bold">Tax:
                                        <span> ${{ 0 }} </span>
                                    </p>
                                </div>

                                <div>
                                    <p class="fw-bold">Discount:
                                        <span> ${{ $order->discount ?? 0 }} </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="fw-bold">Grand Total:
                                        <span>
                                            ${{ number_format($grandTotal, 2) }}
                                        </span>
                                    </p>
                                </div>

                            </div>
                            <div class="d-flex">
                                <h4 class="fw-bold">Ship To:-- </h4>

                                @if ($order->delivery_type == 'delivery')
                                    <span>{{ $order->orderAddress?->name }}</span>
                                @else
                                    <span>{{ $order->orderStore?->store?->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-8 mt-8">
                    <div class="form_field">
                        <h2 class="text-xl text-slate-800 font-bold mb-6">Order Address</h2>
                        @if ($order->delivery_type == 'delivery')
                            @php
                                $address = $order->orderAddress;
                                $fullAddress = $address->full_address;
                            @endphp
                        @else
                            @php
                                $fullAddress = strip_tags($order->orderStore?->store?->full_address);
                            @endphp
                        @endif
                        @if ($order->delivery_type == 'delivery')
                            <div class="grid gap-3 md:grid-cols-3">
                                <div>
                                    <!-- Start -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="country">Country </label>
                                        <input id="country" class="form-input w-full" type="text" name="country"
                                            placeholder="Country" value="{{ $fullAddress['country'] ?? '' }}" readonly />
                                    </div>
                                    <!-- End -->
                                </div>
                                <div>
                                    <!-- Start -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="last_name">State</label>
                                        <input id="state" class="form-input w-full" type="text" name="state"
                                            placeholder="State" value="{{ $fullAddress['state'] ?? '' }}" readonly />
                                    </div>
                                    <!-- End -->
                                </div>
                                <div>
                                    <!-- Start -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="city">City </label>
                                        <input id="city" class="form-input w-full" type="text" name="city"
                                            value="{{ $fullAddress['city'] ?? '' }}" />
                                    </div>
                                    <!-- End -->
                                </div>
                            </div><br>
                            <div class="grid gap-3 md:grid-cols-1">
                                <div>
                                    <!-- Start -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="address">Address </label>
                                        <textarea class="form-control" rows="2" id="address" name="address" readonly>
                                            {{ $fullAddress['address_line_one'] }},{{ $fullAddress['address_line_two'] ?? '' }}
                                        </textarea>
                                    </div>
                                    <!-- End -->
                                </div>
                            </div><br>
                            <div class="grid gap-3 md:grid-cols-2">
                                <div>
                                    <!-- Start -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="zip">Zip Code</label>
                                        <input id="zip" class="form-input w-full" type="number" name="zipcode"
                                            placeholder="Zip Code" value="{{ $address->zip_code }}" readonly />
                                    </div>
                                    <!-- End -->
                                </div>
                            </div>
                        @else
                            <div class="grid gap-3 md:grid-cols-1">
                                <div>
                                    <!-- Start -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="address">Address </label>
                                        <textarea class="form-control" rows="2" id="address" name="address" readonly>
                                        {!! $fullAddress !!}
                                    </textarea>
                                    </div>
                                    <!-- End -->
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="space-y-8 mt-8">
                    <div class="form_field">
                        <h2 class="text-xl text-slate-800 font-bold mb-6">Order Details</h2>

                        <div class="grid gap-3 md:grid-cols-1">
                            @include('customer.order.component.order-details-box', [
                                'products' => $details,
                            ])
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
