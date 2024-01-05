<!-- Add to cart bar -->
@php
    $total=0;
@endphp
@forelse ($cartProducts as $id=>$product)
@php
    $price= auth()->user() ? $product->product->price : $product['price'];
    $quantity= $product->quantity ?? $product['quantity'];
    $total+= $price * $quantity;
@endphp
@empty
@endforelse
<div id="cart_side" class="add_to_cart right ">
    <a href="javascript:void(0)" class="overlay" onclick="closeCart()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my cart</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeCart()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="cart_media">
            <ul class="cart_product cartProducts">
                @include('frontend.components.cart',['cartProducts'=>$cartProducts])
            </ul>
            <ul class="cart_total">
            <li> subtotal : <span class="sub-price"></span> </li>
            <li> shpping <span class="shippingcost"></span> </li>
            <li> taxes <span class="tax"></span>  </li>
            <li>
                <div class="side-total"> total<span class="total-price">${{ $total ?? 0 }}</span> </div>
            </li>
            <li>
                <div class="buttons"> <a href="{{ route('frontend.cart') }}" class="btn btn-solid btn-sm">view cart</a> <a href="{{ route('frontend.cart') }}" class="btn btn-solid btn-sm ">checkout</a> </div>
            </li>
            </ul>
        </div>
    </div>
</div>
  <!-- Add to cart bar end-->
