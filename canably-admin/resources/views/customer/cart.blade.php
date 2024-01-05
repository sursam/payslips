@extends('frontend.layouts.app',['navbar'=>true,'sidebar'=>false,'footer'=>false])
@push('style')
@endpush
@section('content')
    <div id="Cart" class="w3-container city">
        @php
            $carts = collect(session()->get('cart', []));
        @endphp
        <div class="cart-row">
            <div class="cart-row-heade">
            <h2>My Cart</h2>
            @include('frontend.components.cart-detailed', ['carts' => $carts])
            <div class="cart-row-butn">
                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-12"><a class="apply-coupon default-button" href="#"><span>Clear
                                Cart</span></a> </div>
                    <div class="col-lg-3 col-sm-3 col-12"><a class="p-checkout default-button" href="#"><span>Update
                                Cart</span></a> </div>
                    <div class="col-lg-4 col-sm-3 col-12"><a class="apply-coupon default-button"
                            href="#"><span>Proceed
                                To Checkout</span></a> </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{ asset('assets/frontend/js/cart.js') }}"></script>
@endpush
