@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('style')
@endpush
@section('content')
    @if (Session::has('verification'))
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </symbol>
        </svg>
        <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>
                Your email is verified successfully
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <section class="top-section">
        <!--home slider start-->
        <div class="theme-slider layout-5 home-slide">
            @include('frontend.components.banner', ['banners' => $banners->where('position', 'top')])
        </div>

        <!--home slider end-->
        {{-- <div class="container">
            <div class="card-section1">
                <div class="row">
                    <div class="col-lg-4  col-md-6  col-12">
                        <div class="card-section1-1">
                            <h2>Torch</h2>
                            <h3>THC-O, HHCP &amp; Platinum Rosin</h3>
                            <p>Premium extracts that produce mind blowing effects.</p>
                            <a href="javascript:void(0)" class="shop-now">Shop Now
                                <span>
                                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4  col-md-6  col-12">
                        <div class="card-section1-2">
                            <h3>Canably Marketplace</h3>
                            <h2>SIGN UP TO GET 25% OFF!</h2>
                            <p>Discover a Selection of our Products</p>
                            <a href="#" class="shop-now">Discover Now <span><i class="fa fa-long-arrow-right"
                                        aria-hidden="true"></i></span></a>
                        </div>
                    </div>
                    <div class="col-lg-4  col-md-6  col-12">
                        <div class="card-section1-3">
                            <h2>Kuzz Delta 8</h2>
                            <h3>FROM ONLY $19.95</h3>
                            <a href="#" class="shop-now">Shop Now <span><i class="fa fa-long-arrow-right"
                                        aria-hidden="true"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </section>
    <!------------------------Sign Up and Receive----------------------------------------------------->
    @if ($categories->isNotEmpty())
        <section class="instagram mt-4">
            <div class="container">
                <div class="row">
                    <h2>Top Categories Of The Month</h2>
                    <div class="col p-0 position-relative">
                        <div class="insta-contant1 ">
                            <div class="slide-2 slide_home no-arrow">
                                @include('frontend.components.top-category')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endisset
    <!--instagram start-->
    <!--instagra end-->

    <!-- torch design -->
    <div class="container">
        <div class="card-section1">
            <div class="row">
                @forelse ($contents as $content)
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

                                <a href="{{ $content->link }}" class="shop-now">{{ $content->link_text }} <span><i
                                            class="fa fa-long-arrow-right" aria-hidden="true"></i></span></a>
                            </div>
                        </div>
                    </div>
                    @if ($loop->iteration == 3)
                    @break
                @endif
            @empty
            @endforelse


            {{-- <div class="col-lg-4 col-md-6 col-12">
                    <div class="card-section1-3">
                        <img src="{{asset('assets/frontend//images/Stiizy.png')}}" class="img-fluid" alt="">
                        <div id="overlay"></div>
                        <div class="card-scontent">
                            <h2>Kuzz Delta 8</h2>
                            <h3>FROM ONLY $19.95</h3>
                            <a href="{{ route('frontend.shop.by.category', 'delta-8') }}" class="shop-now">Shop Now
                                <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span></a>
                        </div>

                    </div>
                </div> --}}
        </div>
    </div>
</div>
<!------------------------Sign Up and Receive----------------------------------------------------->
@if ($listDelta8Products->isNotEmpty())
    <section class="ratio_square product">
        <div class="container">
            <h2>Delta 8 Products</h2>
            <div class="row">
                <div class="col">
                    <div class="product-slide-5 product-m no-arrow">
                        @include('frontend.components.products', [
                            'dataProducts' => $listDelta8Products,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!------------------------Sign Up and Receive----------------------------------------------------->
@php
    $middleBanner = $banners->where('position', 'middle')->first();
@endphp
@if ($middleBanner)
    <section class="discount-section" style="background-image:url({{ $middleBanner->display_image }})">
        <div class="container">
            <div class="discount-section-text">
                {!! $middleBanner->description !!}
            </div>
        </div>
    </section>
@endif

<!--------------------------+PlusCBD™-Cannamoly--------------------->
@include('frontend.components.brand')
<!--------------------------+PlusCBD™-Cannamoly--------------------->
@if ($canamolyCbdProducts->isNotEmpty())
    <section class="ratio_square product mt-4">
        <div class="container">
            <h2>+PlusCBD™ & Cannamoly</h2>
            <div class="row">
                <div class="col pr-0">
                    <div class=" product_plus product-m no-arrow">
                        @include('frontend.components.products', [
                            'dataProducts' => $canamolyCbdProducts,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!--------------------------------------------------------------------------------->
<!--media banner start-->
@php
    $bottomBanner = $banners->where('position', 'bottom')->first();
@endphp
@if ($bottomBanner)
    <section class="discount-section" style="background-image:url({{ $bottomBanner->display_image }})">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12">
                    {!! $bottomBanner->description !!}
                    {{-- <div class="our-commitment-row-inner">
                        <div class="row">
                            <div class="services-slide4 no-arrow">
                                <div>
                                    <div class="services-box">
                                        <div class="media">
                                            <div class="icon-wrraper"> <img
                                                    src="{{ asset('assets/frontend/images/c-1.png') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="services-box">
                                        <div class="media">
                                            <div class="icon-wrraper"> <img
                                                    src="{{ asset('assets/frontend/images/c-1.png') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="services-box">
                                        <div class="media">
                                            <div class="icon-wrraper"> <img
                                                    src="{{ asset('assets/frontend/images/c-1.png') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="services-box">
                                        <div class="media">
                                            <div class="icon-wrraper"> <img
                                                    src="{{ asset('assets/frontend/images/c-1.png') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="services-box">
                                        <div class="media">
                                            <div class="icon-wrraper"> <img
                                                    src="{{ asset('assets/frontend/images/c-1.png') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="services-box">
                                        <div class="media">
                                            <div class="icon-wrraper"> <img
                                                    src="{{ asset('assets/frontend/images/c-1.png') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="services-box">
                                        <div class="media">
                                            <div class="icon-wrraper"> <img
                                                    src="{{ asset('assets/frontend/images/c-1.png') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="services-box">
                                        <div class="media">
                                            <div class="icon-wrraper"> <img
                                                    src="{{ asset('assets/frontend/images/c-1.png') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endif
<!--media banner end-->
<!--------------------------------------------------------------------------------->
<section class="ratio_square product">
    <div class="container">
        <h2>Top Rated Products</h2>
        <div class="row">
            <div class="col">
                <div class="product-slide-7 product-m no-arrow">
                    @include('frontend.components.products', [
                        'dataProducts' => $listTopProducts,
                    ])
                </div>
            </div>
        </div>
    </div>
</section>
<!--------------------------------------------------------------------------------->
<!--blog start-->
<section class="blog-row">
    <div class="container">
        <h2>From Our Blog</h2>
        @include('frontend.components.blog')
    </div>
</section>
<!--blog end-->
<!--------------------------------------------------------------------------------->
<!--testimonial start-->
<section class="testimoni-row testimonial4">
    <div class="container">
        <h2>Your Trust is Our Top Concern</h2>
        <div class="row">
            <div class="col-12 pr-0">
                <div class="testimonial-slide no-arrow">
                    @include('frontend.components.testimonial')
                </div>
            </div>
        </div>
    </div>
</section>
<!--testimonial end-->
@endsection
@push('scripts')
<script src="{{ asset('assets/frontend/js/cart.js') }}"></script>
<script src="{{ asset('assets/frontend/js/wishlist.js') }}"></script>
@endpush
