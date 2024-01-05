<h3>Products ({{ count($carts)  }})</h3>
@forelse ($carts as $key=>$product)
    @if (auth()->user())
        @php
            $key = $product->product_id;
            $pId= $key
        @endphp
    @endif
    @php
        $pId= $key
    @endphp
    <div class="shopping-cart-product-box">
        <div class="shopping-cart-product-box-cross">
            <a href="javascript:void(0)" class="removeFromCart" data-id={{ $key }}>
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
        <div class="row">
            <div class="col-lg-2 col-sm-2 col-12">
                <div class="shopping-cart-product-box-img">
                    <img src="{{ $product['image'] ?? asset('assets/admin/images/applications-image-21.jpg') }}" alt="">
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-12">
                <div class="shopping-cart-product-box-text1">
                    <h3>{{$product['name'] ?? $product->product->name }}</h3>
                    <div class="row col-lg-12 col-md-6 col-sm-6">
                        @foreach ($product['attributes'] as $key=>$value)
                            <h3>{{ $key }} - {{ $value }}</h3>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-12">
                <div class="shopping-cart-product-box-text2">
                    <p>{{ $product['price'] ?? $product->product->discounted_price }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-12">
                        {{-- <button type="button" class="quantity-left-minus btn-number butn-wht1" data-type="minus"
                            data-field=""> <i class="fa fa-window-minimize" aria-hidden="true"></i> </button>

                    <input type="number" id="quantity" name="quantity" class="form-control input-number text-center"
                        value="{{ $product['quantity'] ?? 1 }}" min="1" max="100">

                        <button type="button" class="quantity-right-plus btn-number butn-wht2quantity-right-plus btn-number butn-wht2" data-type="plus"
                            data-field=""> <i class="fa fa-plus" aria-hidden="true"></i> </button> --}}



                <div id="input-group" class="cart-count-block">
                    <button type="button" id="sub" data-quantity="{{ $product['quantity'] ?? 1 }}" data-id="{{ $pId }}" class="sub quantity-left-minus btn-number butn-wht1 quantity-minus">-</button>
                    <input class="form-control input-number text-center" type="number" id="1" value="{{ $product['quantity'] }}" min="1" max="3" />
                    <button type="button" id="add" data-quantity="{{ $product['quantity'] ?? 1 }}" data-id="{{ $pId }}" class="add quantity-right-plus btn-number butn-wht2 quantity-right-plus quantity-plus btn-number butn-wht2">+</button>
                </div>

            </div>
            <div class="col-lg-2 col-sm-2 col-12">
                <div class="shopping-cart-product-box-text4">
                    <p class="detail-price" data-tax="0">{{ ($product['price'] ?? $product->product->discounted_price) * $product['quantity'] }}</p>
                </div>
            </div>
        </div>
    </div>
@empty
<div class="font-weight-bold">No product in cart</div>
@endforelse

