@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
    <section class="shop-section">
        <div class="container">
            <div class="shop-header-section">
                <div class="brd-cam">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>/</li>
                        <li>Checkout</li>
                    </ul>
                </div>
                <h2>Checkout</h2>
                <p>Shipping & Billing Details</p>
            </div>
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-sm-4 col-12">
                        <div class="checkout-bg">
                            <p>Shipping Details</p>
                            <div class="form-row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name" value="{{ $default_address->name ?? '' }}">
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="full_address[address_line_one]" id="address_line_one"
                                        class="form-control" placeholder="Address Line 1"
                                        value="{{  $default_address->full_address['address_line_one'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="full_address[address_line_two]" id="address_line_two"
                                        class="form-control" placeholder="Address Line 2"
                                        value="{{ $default_address->full_address['address_line_two'] ?? '' }}">
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="number" name="phone_number" id="phone_number" class="form-control"
                                        placeholder="Phone"
                                        value="{{  $default_address->phone_number ?? '' }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" class="form-control" placeholder="Street Address" value="{{ $getOrderSession['street_address'] }}">
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="full_address[city]" id="city" class="form-control"
                                        placeholder="Suburb/City"
                                        value="{{ $default_address->full_address['city'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="full_address[state]" id="state" class="form-control"
                                        placeholder="State"
                                        value="{{ $default_address->full_address['state'] ?? '' }}">
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="zip_code" id="zip_code" class="form-control"
                                        placeholder="Zip code" readonly
                                        value="{{ $default_address->zip_code ?? $getOrderSession['pincode'] }}">
                                </div>
                            </div>
                            <p>Billing Details
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck" required>
                                <label class="form-check-label" for="gridCheck"> Same as shipping details </label>
                            </div>
                            </p>
                            <div class="form-row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="name" id="address_name" class="form-control"
                                        placeholder="Name">
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="full_address[address_line_one]"
                                        id="shipping_address_line_one" class="form-control" placeholder="Address Line 1">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="full_address[address_line_two]"
                                        id="shipping_address_line_two" class="form-control" placeholder="Address Line 2">
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="number" name="phone_number" id="shipping_phone_number"class="form-control"
                                        placeholder="Phone">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="shipping_address[street_address]" class="form-control"
                                        placeholder="Street Address">
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="full_address[city]" id="shipping_city"
                                        class="form-control" placeholder="Suburb/City">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="full_address[state]" id="shipping_state"
                                        class="form-control" placeholder="State">
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <input type="text" name="zip_code" id="shipping_zip_code" class="form-control"
                                        placeholder="Zip code">
                                </div>
                            </div>
                            <p>Additional Information</p>
                            <div class="form-group">
                                <textarea class="form-control" id="additional_info" name="additional_info" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-12">
                        <div class="checkout-bg-right">
                            <h3>Your Order</h3>
                            <div class="checkout-bg-right-part">
                                <h6>Details</h6>

                                @include('customer.payment.components.details', [
                                    'details' => $carts ?? [],
                                ])
                                @php
                                    $discount= session()->get('order-' . auth()->user()->uuid . '.discount', 0);
                                    $detailsTotal = $carts->sum(function ($details) {
                                        return $details->quantity * $details->product->price;
                                    });
                                    $subtotal= $detailsTotal;
                                    $detailsTotal-= $discount;
                                @endphp
                                <br clear="all">
                                <hr>
                                {{-- <p><span class="left-text"><b> Sub Total </b></span> <span><b class="sub-total"></b></span></p> --}}
                                <input type="hidden" class="shippingCost"
                                    value="{{ session()->get('order-' . auth()->user()->uuid . '.shipping_cost', 0) }}">
                                <p><span class="left-text"> Subtotal </span> <span><b
                                            class="shippingcost">${{ $subtotal ?? 0 }}</b></span></p>
                                <p><span class="left-text"> Shipping Flat Rate </span> <span><b
                                            class="shippingcost">$</b></span></p>
                                <p><span class="left-text">Tax </span> <span><b>$0</b></span></p>
                                <p><span class="left-text"> Discount </span> <span><b>${{ session()->get('order-' . auth()->user()->uuid . '.discount', 0) }}</b></span></p>
                                <br clear="all">
                                <hr>
                                <p><span class="left-text"><b> Total </b></span> <span><b
                                            class="">${{ $detailsTotal }}</b></span></p>
                                <input type="submit" class="p-checkout default-button" value="Proceed To Pay">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/frontend/js/cart.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/checkout.js') }}"></script>
@endpush
