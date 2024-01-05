
@forelse ($products as $product)
    <div class="all-order-box-butm2">
        <div class="row">
            <div class="col-lg-2">
                <div class="all-order-box-butm2-img-new">
                    <img src="{{ $product->product->latest_image }}" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="all-order-box-butm2-text">
                    <h2>{{ $product->product->title ?? $product->product->name  }} x {{ $product->quantity }}</h2>
                    <p>
                        @forelse ($product->attributes as $attributeKey=>$attributeValue)
                            {{ $attributeKey }} :- {{ $attributeValue }}<br>
                        @empty

                        @endforelse
                    </p>
                </div>
            </div>
            @if (auth()->user()->hasRole('customer'))
                <div class="col-lg-4"> <a class="apply-coupon default-button" href="javascript:void(0)"><span>Write A Review</span></a> </div>
            @endif

        </div>
    </div>
@empty
@endforelse
