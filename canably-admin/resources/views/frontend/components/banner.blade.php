{{-- <div class="row">
    <div class="col-lg-5 col-sm-5 col-12">
        <div class="banner-inner-left">
            <h1>Canably<br>
                CBD Marketplace</h1>
            <p>Your one-stop shop for CBD / Delta 8 Products & More — Start your CBD journey
                with us
                risk-free.</p>
            <a class="banner-shop-now default-button" href="#"><span>Shop
                    Now</span></a>
            <div class="banner-inner-left-butm">
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-12">
                        <h4><span><i class="fa fa-truck" aria-hidden="true"></i></span> Free
                            Shipping &amp; Returns
                        </h4>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <h4><span><i class="fa fa-thumbs-o-up"
                                    aria-hidden="true"></i></span> Satisfaction
                            Guaranteed </h4>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <h4><span><i class="fa fa-credit-card" aria-hidden="true"></i></span> 100% Secure Payment
                        </h4>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <h4><span><i class="fa fa-headphones" aria-hidden="true"></i></span>
                            24x7 Customer Support
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-sm-7 col-12">

    </div>
</div> --}}


<div class="main-banner">
    <div class="banner-inner-right">
        <div class="img_single_slide">
            @forelse ($banners as $banner)
                <div>
                    <div class="hero_box">
                        <img src="{{ $banner->display_image }}" class="img-fluid" alt="slider">

                        <div class="heroimg_content">
                            {!! $banner->description !!}
                        </div>
                    </div>
                </div>
            @empty
                <div>
                    <a href="javascript:void(0)">
                        <img src="{{ asset('assets/frontend/images/banner-img1.png') }}" class="img-fluid"
                            alt="slider">
                    </a>

                </div>
            @endforelse


        </div>

    </div>
</div>
