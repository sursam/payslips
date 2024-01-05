@php
    $existingWishlist =
        auth()
            ->user()
            ?->wishlists->pluck('product_id')
            ->toArray() ?? [];
@endphp
@forelse ($dataProducts as $dataProduct)
    <div>
        <div class="product-box product-box2">
            <div class="product-imgbox">
                <div class="product-front"> <a href="javascript:void(0)"> <img src="{{ $dataProduct->latest_image }}"
                            class="img-fluid" alt="product"> </a>
                </div>
                <div class="product-icon icon-inline">
                    @auth
                        <a href="javascript:void(0)"  class="add-to-wish tooltip-top addToWishlist"
                            data-uuid="{{ $dataProduct->uuid }}" data-tippy-content="Add to Wishlist">
                            @php
                                $class = in_array($dataProduct->id, $existingWishlist) ? 'fa-solid' : 'fa-regular';
                            @endphp
                            <i class="{{ $class }} fa-heart" aria-hidden="true" id="{{ $dataProduct->uuid }}_v"></i> </a>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="add-to-wish tooltip-top addToWishList"
                            data-uuid="{{ $dataProduct->uuid }}" data-tippy-content="Add to Wishlist"> <i
                                class="fa-regular fa-heart" aria-hidden="true"></i> </a>
                    @endguest
                </div>
            </div>
            <div class="cannamoly-box-text product-detail product-detail2">
                <div class="flex space-x-1 profile-rating">
                    <div class="show-rating-list profile-rating--list">
                        @php
                            $filledWidth = (($dataProduct->average_rating / 5) * 100)
                        @endphp
                        <div class="rating_area">
                            <div class="gray_rating"></div>
                            <div class="filled_rating" style="width: {{ $filledWidth }}%;"></div>
                        </div>
                    </div>
                </div>
                 <!-- Rate -->
                 <div class="inline-flex text-sm font-medium text-amber-600">{{ $dataProduct->average_rating >0 ? $dataProduct->average_rating : 'No Rating yet' }}</div>
                <a href="{{ route('frontend.product.details',$dataProduct->uuid) }}">
                    <p>{{ $dataProduct->name }}</p>
                </a>
                <h3>{{ $dataProduct->category->name }}</h3>
                <a class="add-to-cart default-button addToCart" data-uuid="{{ $dataProduct->uuid }}"
                    href="javascript:void(0)"><span>Add to Cart</span></a>
            </div>
        </div>
    </div>
@empty
@endforelse
