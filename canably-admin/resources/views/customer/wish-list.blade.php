@extends('customer.layouts.app', ['navbar' => true, 'sidebar' => true, 'footer' => false])
@push('style')
@endpush
@section('content')
    <div id="Wishlist" class="w3-container city">
        <div class="wishlist">
            <h2>My Wishlist</h2>
            @forelse ($wishlists as $wishlist)
                <div class="my-wishlist-box">
                    <div class="row">
                        <div class="col-lg-2 col-sm-2 col-12">
                            <div class="my-wishlist-box-img"> <img src="{{ $wishlist->product?->latestImage }}"
                                    alt=""> </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-12">
                            <div class="my-wishlist-box-text1">
                                <h2>{{ $wishlist->product ? $wishlist->product->name : '--'  }}</h2>
                                {{--  <p>350 mg</p>  --}}
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-1 col-12">
                            <div class="my-wishlist-box-text2">
                                <h3>${{ $wishlist->product?->price ? number_format($wishlist->product->price, 2) : '0.00' }}</h3>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-12">
                            <div class="my-wishlist-box-butn"> <a class="apply-coupon default-button"
                                    href="javascript:void(0)"><span>Add to Cart</span></a> </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-12">
                            <div class="my-wishlist-box-butn"> <a class="p-checkout default-button"
                                    href="javascript:void(0)"><span>Remove</span></a> </div>
                        </div>
                    </div>
                </div>
            @empty
                <div>
                    <h4>'No Data Found !!'</h4>
                </div>
            @endforelse
        </div>
    </div>
@endsection
@push('scripts')
@endpush
