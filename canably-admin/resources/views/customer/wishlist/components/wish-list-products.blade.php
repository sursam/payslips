 <h2>My Wishlist({{ $wishlists->count() }})</h2>
 @forelse ($wishlists as $wishlist)
     <div class="my-wishlist-box">
         <div class="row">
             <div class="col-lg-2 col-md-12 col-12">
                 <div class="my-wishlist-box-img"> <img src="{{ $wishlist->product?->latestImage }}" alt=""> </div>
             </div>
             <div class="col-lg-3 col-md-3 col-12">
                 <div class="my-wishlist-box-text1">
                     <h2>{{ $wishlist->product ? $wishlist->product->name : '--' }}</h2>
                     {{--  <p>350 mg</p>  --}}
                 </div>
             </div>
             <div class="col-lg-3  col-md-3 col-12 text-center">
                 <div class="my-wishlist-box-text2">
                     <h3>${{ $wishlist->product?->price ? number_format($wishlist->product->price, 2) : '0.00' }}</h3>
                 </div>
             </div>
             <div class="col-lg-3  col-md-3 col-12">
                 <div class="my-wishlist-box-butn"> <a class="apply-coupon default-button AddToCartProduct"
                         href="javascript:void(0)" data-uuid="{{ $wishlist->product?->uuid }}"><span>Add to Cart</span></a> </div>
             </div>

         </div>

         <a href="javascript:void(0)" class="removeFromCart removeFromWishlist"
             data-uuid="{{ $wishlist->product?->uuid }}">
             <i class="fa fa-times" aria-hidden="true"></i>
         </a>
     </div>
 @empty
     <div class="my-wishlist-box">
         <h4>No Data Found !!</h4>
     </div>
 @endforelse
