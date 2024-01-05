@extends('customer.layouts.app', ['navbar' => true, 'sidebar' => true, 'footer' => false])
@push('style')
@endpush
@section('content')
    <div id="Book" class="w3-container city">
        <div class="addrs-book">
            <h2>Address Book</h2>
            <div class="row" id="address-card">
                @include('customer.address.components.addreess',['addresses'=>$addresses])
            </div>
        </div>
    </div>
    @include('modals.address-modal')
@endsection
@push('scripts')
<script src="{{ asset('assets/frontend/js/address.js') }}"></script>
@endpush
