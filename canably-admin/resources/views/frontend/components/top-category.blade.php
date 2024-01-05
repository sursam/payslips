@forelse ($categories as $category)
    <div>
        <div class="instagram-box cata_box">
            <a href="{{ route('frontend.shop.by.category',$category->slug) }}"><img src="{{ $category->display_image }}" class="img-fluid" alt="insta"></a>
            <p>{{ $category->name }}</p>
        </div>
    </div>
@empty

@endforelse

