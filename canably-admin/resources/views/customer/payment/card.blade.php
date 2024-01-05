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
                        <li>Payment Method</li>
                    </ul>
                </div>
                <h2>Payment Method</h2>
                <h4>Card Details</h4>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12">
                    <div class="checkout-bg">
                        <div class="row">
                            <div class="col-lg-5 col-sm-5 col-12">
                                <form method="POST" class="require-validation" data-cc-on-file="false"
                                    data-stripe-publishable-key="{{ config('constants.STRIPE_KEY') }}" id="payment-form">
                                    @csrf
                                    <div class="form-group required">
                                        <label for="card-number">Card Number</label>
                                        <input type="text" class="form-control card-number" id="card-number"
                                            name="card-number" size="20" placeholder="1234 5678 9010 8976">
                                    </div>
                                    <div class="form-group required">
                                        <label type="expiry-month ">Expiry (MM)*</label>
                                        <input type="text" class="form-control card-expiry-month" id="expiry-month"
                                            name="expiry-month" size="2">
                                    </div>
                                    <div class="form-group required">
                                        <label type="formGroupExampleInput card-expiry-year">Expiry (YYYY)*</label>
                                        <input type="text" name="expiry-year" size="4"
                                            class="form-control card-expiry-year">
                                    </div>
                                    <div class="form-group required">
                                        <label for="card-cvc">Card CVC</label>
                                        <input type="number" name="card-cvc" class="form-control card-cvc cc-cvc-input"
                                            id="card-cvc" placeholder="CVC">
                                    </div>
                                    <div class="form-group required">
                                        <label for="card-name">Card Holder Name</label>
                                        <input type="text" name="card-name" class="form-control" id="card-name"
                                            placeholder="Enter Name" size="4">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check required">
                                            <label class="form-check-label" for="gridCheck">
                                                <input class="form-check-input" name="tandc" type="checkbox"
                                                    id="gridCheck">
                                                I have read and agree to the website
                                                <span class="green-text">
                                                    <a
                                                        href="{{ route('frontend.pages.any.pages', 'terms-and-conditions') }}">terms
                                                        and conditions*</a>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="opaqueDataValue" id="opaqueDataValue" />
                                    <input type="hidden" name="opaqueDataDescriptor" id="opaqueDataDescriptor" />
                                    <input type="submit" class="p-checkout default-button" value="Place Order">
                                    {{-- <a class="p-checkout default-button" href="#"><span>Place Order</span></a> --}}
                                </form>
                            </div>
                            <div class="col-lg-7 col-sm-7 col-12">
                                <div class="payment-right-bg">
                                    <img src="{{ asset('assets/frontend/images/payment-right.png') }}"
                                        alt="cart-default-image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        var CLIENT_KEY= "{!! config('constants.AUTHORIZE_CLIENT_KEY') !!}"
        var AUTHORIZE_TRANSACTION_KEY= "{!! config('constants.AUTHORIZE_TRANSACTION_KEY') !!}"
        var AUTHORIZE_LOGINID= "{!! config('constants.AUTHORIZE_LOGINID') !!}"
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <script src="https://jstest.authorize.net/v1/Accept.js" charset="utf-8"></script>
    {{-- <script type="text/javascript" src="https://js.stripe.com/v2/"></script> --}}
    <script src="{{ asset('assets/frontend/js/payment.js') }}"></script>

@endpush
