
@forelse ($details as $cart)
<p>
    <span class="left-text"> {{ $cart->product->name }}
        {{-- <p> --}}
            @foreach ($cart['attributes'] as $key=>$value)
                {{ $key }} - {{ $value }}
            @endforeach × {{ $cart->quantity }}
        {{-- </p> --}}
    </span>
    <span> $<span class="detail-price">{{ ($cart->quantity)*($cart->product->discounted_price) }}</span></span>
</p>
@empty
<p>
    <span class="left-text">No data in cart</span>
    <span class="detail-price">$0</span>
</p>
@endforelse

