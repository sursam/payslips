@if ($listBrands->isNotEmpty())
    <section>
        <div class="container">
            <div class="our-band">
                <h2>Discover Our Selection of Brands</h2>
                <div class="our-band-inner">
                    <div class="row row-cols-lg-5">
                        @forelse ($listBrands as $brand)
                            <div class="col">
                                <div class="our-banner-box-outer">
                                    <div class="our-banner-box">
                                        <div class="row align-items-center">
                                            <div class="our-banner-box-icon col-lg-5"> <img
                                                    src="{{ $brand->display_image }}" alt="">
                                            </div>
                                            <div class="our-banner-box-text col-lg-7">
                                                <h3> <a
                                                        href="{{ route('frontend.shop.by.type', ['type' => 'brand', 'value' => $brand->slug]) }}">{{ $brand->name }}
                                                    </a> </h3>
                                                <p> {{ $brand->name }} ({{ $brand->products->count() }} Products) </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div>
                                <h4 class="px-2 first:pl-5 last:pr-5 py-3 text-center whitespace-nowrap">No
                                    Data Found Yet</h4>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="card-section2">
                <div class="row">
                    @forelse ($contents as $content)
                        @if ($loop->iteration > 3)
                            <div class="col-lg-4  col-md-6  col-12">
                                <div class="card-section1-2">
                                    <img src="{{ $content->display_image }}" class="img-fluid" alt="">
                                    <div id="overlay"></div>
                                    <div class="card-scontent">
                                        <h2>{{ $content->title }}</h2>
                                        <h3>{{ $content->sub_title }}</h3>
                                        @if ($content->description)
                                            <p>{!! $content->description !!}</p>
                                        @endif

                                        <a href="{{ $content->link }}" class="shop-now">{{ $content->link_text }}
                                            <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span></a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($loop->iteration == 6)
                            @break
                        @endif
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endif
