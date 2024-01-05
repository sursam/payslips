@php
    $existingWishlist = auth()->user()?->wishlists->pluck('product_id')->toArray() ?? [];
@endphp
@forelse ($products as $product)
    <div class="col-lg-4  col-md-6 col-sm-12 col-12 sm-mb-30">
        <div class="cannamoly-box">
            <div class="wish-list-icon">
                @auth
                    <a href="javascript:void(0)" class="addToWishlist uuid{{ $product->uuid }}"
                        data-uuid="{{ $product->uuid }}">
                        @php
                            $class = in_array($product->id, $existingWishlist) ? 'fa-solid' : 'fa-regular';
                        @endphp
                        <span><i class="{{ $class }} fa-heart" aria-hidden="true" id="{{ $product->uuid }}_v"></i></span>
                    </a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="addToWishlist" data-uuid="{{ $product->uuid }}"><i
                            class="fa-regular fa-heart" aria-hidden="true"></i></a>
                @endguest
            </div>
            <div class="cannamoly-box-img">
                <a href="{{ route('frontend.product.details', $product->uuid) }}"><img
                        src="{{ $product->latest_image }}" alt="{{ $product->name }}"></a>
            </div>
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
                <h3>${{ $product->price }}</h3>
            </div>
            <a class="add-to-cart default-button addToCart" data-uuid="{{ $product->uuid }}"
                href="javascript:void(0)"><span>Add to Cart</span></a>
        </div>
    </div>
@empty
    No Data Found
@endforelse
