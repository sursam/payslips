@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
    <section class="shop-section">
        <div class="container">
            <div class="thank-you">
                <div class="thank-you-img">
                    <img src="{{ asset('assets/frontend/images/thank-u.png') }}" alt="">
                </div>
                <h2>Thank you for your order</h2>
                <h4>Your order number is: <span> {{ session()->get('order_id') }} </span> </h4>
                <h4>We'll email you an order confirmation with details and tracking info.</h4>
                <a class="thank-butn default-button" href="{{ route('customer.order.list') }}"><span>Go to Orders</span></a>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/frontend/js/cart.js') }}"></script>
@endpush
