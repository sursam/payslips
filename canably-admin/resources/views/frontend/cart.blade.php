@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
{{-- @include('errors.all') --}}
    @php
        $carts = auth()->user() ? auth()->user()->carts : session()->get('cart', []);
        $check= auth()->user() && $carts->isNotEmpty() ? 1 :0;
    @endphp
    <section class="shop-section">
        <input type="hidden" name="check" value="{{ $check }}" >
        <div class="container">
            <div class="shop-header-section">
                <div class="brd-cam">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>/</li>
                        <li>Shopping Cart</li>
                    </ul>
                </div>
                <h2>Shopping Cart</h2>
            </div>
            <div class="row">
                <div class="col-lg-8 col-sm-4 col-12">
                    <div class="coupon-discount">
                        <h3>Coupon Discount</h3>
                        <div class="row">
                            <div class="col-lg-5 col-sm-5 col-12">
                                <form >
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control coupon" id="exampleFormControlInput1" @guest disabled @endguest @if (auth()->user() && !$check)
                                            disabled
                                        @endif placeholder="Enter coupon code here...">
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="d-flex gap-2">
                                    <a class="apply-coupon default-button @guest pe-none @endguest @if (auth()->user() && !$check)
                                        pe-none
                                    @endif  applyCoupon "  href="javascript:void(0)"><span>Apply Coupon</span></a>

                                    <a class="apply-coupon default-button @guest pe-none @endguest @if (auth()->user() && !$check)
                                        pe-none
                                    @endif  removeCoupon "  href="javascript:void(0)" style="display: none"><span>Remove Coupon</span></a>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="shopping-cart-product">

                        <div class="cart-card">
                            @include('frontend.components.cart-detailed', ['carts' => $carts])
                        </div>

                        <div class="row">
                            <div class="shopping-cart-product-but-row">
                                <a class="shopping-cart-product-but default-button clearCart" href="javascript:void(0)">
                                    <span>Clear Cart</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-12">
                    <form id="delivery-form" enctype="multipart/form-data" method="post" action="{{ route('frontend.cart') }}">
                        @csrf
                        <div class="shop-cart-right-part">
                            <h3>Cart Total</h3>
                            <div class="shop-cart-right-part1">
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input delivery-type" type="radio" name="delivery_type"
                                            id="delivery" value="delivery" checked>
                                        <label class="form-check-label" for="delivery">Delivery</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input delivery-type" type="radio" name="delivery_type" id="delivery" value="shipping" disabled>
                                        <label class="form-check-label" for="delivery">Shipping</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input delivery-type" type="radio" name="delivery_type"
                                            id="storePickup" value="store-pickup">
                                        <label class="form-check-label" for="storePickup">Store Pickup </label>
                                    </div>
                                    @error('delivery_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="delivery">
                                    <div class="form-group">
                                        <select class="form-control getPopulate countries" name="country"
                                            data-location="states" data-message="state" data-auth="california">
                                            <option value="">Select Country</option>
                                            {{-- @auth --}}
                                                @forelse ($countries as $country)
                                                    <option value="{{ $country->id }}" @if ($country->slug=='united-states') selected @endif
                                                        data-populate="{{ json_encode($country->states->sortByDesc('slug')->pluck('name', 'id')) }}">
                                                        {{ $country->name }}</option>
                                                @empty
                                                @endforelse
                                            {{-- @endauth --}}
                                        </select>
                                        @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control states" name="state" data-location="cities">
                                            <option value="">Select State</option>
                                            {{-- States will be append using the js here --}}
                                        </select>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control cities" name="city">
                                            <option value="">Select City</option>
                                            {{-- Cities will be append using the js here --}}
                                        </select>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control delivery_zipcode" name="pincode" min="10000"
                                            max="999999" placeholder="Enter Zip code" >
                                    </div>
                                    @error('pincode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group">
                                        <input type="text" class="form-control street_address" name="street_address" placeholder="Please enter street address">
                                    </div>
                                    @error('street_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="store-pickup d-none">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="zip_code" placeholder="ZIP" value="92103" readonly>
                                        @error('zip_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group addr-part" id="pickupAddress">
                                        {{-- Store address will be append using the js here --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="update-total">
                            <h3>Update Totals</h3>
                            <p>Items
                                <span class="cart-items"></span>
                            </p>
                            <p>SubTotal <span class="subtotal"></span></p>
                            <p>Tax <span class="tax"></span></p>
                            <input type="hidden" name="tax" class="tax">
                            <p>Shipping <span class="shippingcost"></span></p>
                            <input type="hidden" name="shipping_cost" class="shippingcost">
                            <p>Discount <span class="discount">$0</span></p>
                            <h6>Total <span class="total"></span> </h6>
                            <input type="hidden" name="total" class="total">
                            @error('shipping_cost')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if (
                                (!empty($carts) && !auth()->user()) ||
                                    (auth()->user() &&
                                        auth()->user()->carts->isNotEmpty()))
                                @guest
                                    <a class="p-checkout default-button checkoutBtn"
                                        href="{{ route('login') }}">
                                        <span>Proceed To Checkout</span>
                                    </a>
                                @endguest
                                @auth
                                    <button class="p-checkout default-button checkoutBtn" disabled type="submit">
                                        <span>Proceed To Checkout</span>
                                    </button>
                                @endauth
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/frontend/js/cart.js') }}"></script>
@endpush
