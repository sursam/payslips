@php
    $existingWishlist = auth()->user()?->wishlists->pluck('product_id')->toArray() ?? [];
@endphp
@forelse ($products as $product)
    <div class="product_horizonrtal_card">
        <div class="product-img">
            <a href="{{ route('frontend.product.details', $product->uuid) }}"><img src="{{ $product->latest_image }}" alt="{{ $product->name }}"></a>
        </div>
        <div class="product-details">
            <div class="flex space-x-1 profile-rating">
                <div class="show-rating-list profile-rating--list">
                    @php
                        $filledWidth = (($product->average_rating / 5) * 100)
                    @endphp
                    <div class="rating_area">
                        <div class="gray_rating"></div>
                        <div class="filled_rating" style="width: {{ $filledWidth }}%;"></div>
                    </div>
                </div>
            </div>
             <!-- Rate -->
             <div class="inline-flex text-sm font-medium text-amber-600">{{ $product->average_rating >0 ? $product->average_rating : 'No Rating yet' }}</div>
            <div class="cannamoly-box-text">
                <a href="{{ route('frontend.product.details', $product->uuid) }}">
                    <p>{{ $product->name }}</p>
                </a>
                <h3>{{ $product->category->name }}</h3>
            </div>
            <div class="product_price">${{ $product->price }}</div>
            <div class="product_actions_btn">
                <a href="javascript:void(0)" class="addToCart" data-uuid="{{ $product->uuid }}">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                </a>
                @auth
                    <a href="javascript:void(0)" class="addToWishlist uuid{{ $product->uuid }}" data-uuid="{{ $product->uuid }}">
                        @php
                            $class = in_array($product->id, $existingWishlist) ? 'fa-solid' : 'fa-regular';
                        @endphp
                        <span><i class="{{ $class }} fa-heart" aria-hidden="true" id="{{ $product->uuid }}_h"></i></span>
                    </a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="addToWishlist" data-uuid="{{ $product->uuid }}"><i
                            class="fa-regular fa-heart" aria-hidden="true"></i></a>
                @endguest
            </div>
        </div>
    </div>
@empty
    No Data Found
@endforelse
