@extends('customer.layouts.app', ['navbar' => true, 'sidebar' => true, 'footer' => false])
@push('style')
@endpush
@section('content')
    <div id="Orders" class="w3-container city">
        <h2>My Orders</h2>
        <div class="my-order-inner">
            <ul class="nav nav-tabs" id="orderTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-orders-tab" data-bs-toggle="tab" data-bs-target="#all-orders" type="button" role="tab" aria-controls="all-tab" aria-selected="true" >All Orders</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="true">Completed</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab" aria-controls="cancelled" aria-selected="true">Cancelled</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active container" id="all-orders" role="tabpanel" aria-labelledby="all-orders-tab">

                </div>

                <div class="tab-pane fade container" id="completed" role="tabpanel" aria-labelledby="completed-tab">

                </div>

                <div class="tab-pane fade container" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/frontend/js/order.js') }}"> </script>
@endpush
