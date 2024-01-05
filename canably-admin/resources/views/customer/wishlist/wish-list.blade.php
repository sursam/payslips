@extends('customer.layouts.app', ['navbar' => true, 'sidebar' => true, 'footer' => false])
@push('style')
@endpush
@section('content')
    <div id="Wishlist" class="w3-container city">
        <div class="wishlist">
            
            <div id="wishlistHtmlDetails">
                @include('customer.wishlist.components.wish-list-products',['wishlists'=>$wishlists])
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/frontend/js/wishlist.js') }}"></script>
@endpush
