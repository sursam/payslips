@forelse ($cartProducts as $id=>$product)
    @if (auth()->user())
        @php
            $id= $product->product_id
        @endphp

    @endif
    @php
        $quantity= $product->quantity ?? $product['quantity']
    @endphp
    <li>
        <div class="media">
            <a href="javascript:void(0)">
                @guest()
                    <img class="me-3" src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                @endguest
                @auth
                    <img class="me-3" src="{{ $product->product->latest_image }}" alt="{{ $product->product->name }}"/>
                @endauth

            </a>
            <div class="media-body"> <a href="javascript:void(0)">
                    <h4>{{ $product['name'] ?? $product->product->name }}</h4>
                </a>
                <h6 class="price" data-shippingCost="0" data-tax="0"> {{ $product['price'] ?? $product->product->discounted_price }} </h6>
                <div class="addit-box">
                    <div class="qty-box">
                        <div class="input-group">
                            <button class="qty-minus quantity-minus sub" data-id="{{ $id }}" data-quantity="{{ $quantity ?? 1 }}"></button>
                            <input class="qty-adj form-control" type="number" value="{{ $quantity ?? 1 }}" />
                            <button class="qty-plus quantity-plus add" data-id="{{ $id }}" data-quantity="{{ $quantity ?? 1 }}"></button>
                        </div>
                    </div>
                    <div class="pro-add">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#edit-product">
                            <i data-feather="edit"></i>
                        </a>
                        <a href="javascript:void(0)"><i data-feather="trash-2"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </li>
@empty

@endforelse


