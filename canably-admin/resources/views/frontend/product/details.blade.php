@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/fancy-box.css') }}">
@endpush
@section('content')
    <section class="shop-section">
        <div class="container">
            <div class="shop-header-section">
                <div class="brd-cam">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>/</li>
                        <li><a href="#">Shop By Cannabinoids</a></li>
                        <li>/</li>
                        <li><a href="#">{{ $productData->category?->name }}</a></li>
                        <li>/</li>
                        <li><a href="{{ url()->current() }}">{{ $productData->name }}</a></li>
                    </ul>
                </div>
                <h2>{{ $productData->name }}</h2>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-12">
                    <div class="product-detalis-left">
                        <div class="boxzoom">
                            <div class="zoom-thumb">
                                <ul class="piclist">
                                    @forelse ($productData->product_images as $image)
                                        @if ($loop->iteration == 1)
                                            @php
                                                $featuredImage= $image;
                                            @endphp
                                        @endif
                                        <li><img src="{{ $image }}" alt=""></li>
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                            <div class="_product-images">
                                <div class="picZoomer"> <img class="my_img" src="{{ $featuredImage }}" alt=""> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-12">
                    <div class="product-detalis-right">
                        <div class="product-detalis-right-icon">
                            <ul>
                                <li><a href="{{ getSiteSetting('facebook_url') }}"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="{{ getSiteSetting('twitter_url') }}"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="{{ getSiteSetting('instagram_url') }}"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="{{ getSiteSetting('linkedin_url') }}"><i class="fa-brands fa-linkedin"></i></a></li>
                                <li><a href="{{ getSiteSetting('google_url') }}"><i class="fa-brands fa-google"></i></a></li>
                                <li><a href="{{ getSiteSetting('yelp_url') }}"><i class="fa-brands fa-yelp"></i></a></li>
                            </ul>
                        </div>
                        <h6>Categories:<span>{{ $productData->category?->name }} </span></h6>
                        <h6>SKU:<span>{{ $productData->stock?->sku }}</span></h6>
                        <h6>Tags:
                            @if ($productData->tags)
                                <span>
                                    {{ !is_null($productData->tags['product_tag']) ? json_encode($productData->tags['product_tag']) : '' }}
                                </span>
                            @endif
                        </h6>
                        <h6>Price:<span>${{ $productData->price }}</span></h6>

                        @if ($productData->description)
                            <h6>Description:</h6>
                            <p>{{ $productData?->description }}</p>
                        @endif

                        <div class="process-row">
                            <div class="process-row-box">
                                <span><i class="fa fa-truck" aria-hidden="true"></i></span>
                                <h2>Free Shipping & Returns</h2>
                                <p>For all orders over $100</p>
                            </div>
                            <div class="process-row-box">
                                <span><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                                <h2>Secure Payment</h2>
                                <p>Ensure secure payment</p>
                            </div>
                            <div class="process-row-box">
                                <span><i class="fa fa-tag" aria-hidden="true"></i></span>
                                <h2>Coupon Discount</h2>
                                <p>Buy One Get One Free</p>
                            </div>
                        </div>
                        <div class="flex space-x-1 profile-rating product-rating">
                            <div class="show-rating-list profile-rating--list">
                                @php
                                    $filledWidth = (($productData->average_rating / 5) * 100)
                                @endphp
                                <div class="rating_area">
                                    <div class="gray_rating"></div>
                                    <div class="filled_rating" style="width: {{ $filledWidth }}%;"></div>
                                </div>
                            </div>
                        </div>
                         <!-- Rate -->
                         <div class="inline-flex text-sm font-medium text-amber-600">{{ $productData->average_rating >0 ? $productData->average_rating : 'No Rating yet' }}</div>
                        <div class="upper-row">
                            @forelse ($productData->specifications as $specificationKey=>$specificationValue)
                                <div class="row align-items-center mt-3">
                                    {{ $specificationKey }}:
                                    <select class="form-select" aria-label="Default select example"
                                        name="attributes[{{ strtolower($specificationKey) }}]">
                                        <option value="">-Choose {{ $specificationKey }}-</option>
                                        @forelse ($specificationValue as $optionValue)
                                            <option value="{{ $optionValue['id'] }}">
                                                {{ $optionValue['value'] }}
                                            </option>
                                        @empty
                                            <option value="">No Flavour Available!</option>
                                        @endforelse
                                    </select>
                                </div>
                            @empty

                            @endforelse
                        </div>
                        <div class="whatsapp-bg">
                            <span><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                            <h3>Need help? Chat via WhatsApp</h3>
                            <h4>Diego / Customer Service Representative</h4>
                        </div>
                        <a class="shop-shop-now default-button addToCart" data-uuid="{{ $productData->uuid }}"
                            href="javascript:void(0)"><span>Add
                                to Cart</span></a>
                    </div>
                </div>
            </div>
            <section class="tab-product tab-exes">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <div class="creative-card creative-inner">
                                <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="top-home-tab"
                                            data-bs-toggle="tab" href="#top-home" role="tab"
                                            aria-selected="false">Description
                                        </a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab"
                                            href="#top-profile" role="tab" aria-selected="false">Specification</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab"
                                            href="#top-contact" role="tab" aria-selected="false">Reviews({{ $productData->reviews->count() }})</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="review-top-tab" data-bs-toggle="tab"
                                            href="#top-review" role="tab" aria-selected="false">Vendor Info</a>
                                        <div class="material-border"></div>
                                    </li>

                                    <li class="nav-item"><a class="nav-link" id="review-top-tab" data-bs-toggle="tab"
                                            href="#top-contact" role="tab" aria-selected="false">More Offers</a>
                                        <div class="material-border"></div>
                                    </li>

                                    <li class="nav-item"><a class="nav-link" id="review-top-tab" data-bs-toggle="tab"
                                            href="#top-contact" role="tab" aria-selected="false">Store Policies</a>
                                        <div class="material-border"></div>
                                    </li>

                                    <li class="nav-item"><a class="nav-link" id="review-top-tab" data-bs-toggle="tab"
                                            href="#top-contact" role="tab" aria-selected="false">Enquiries</a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                <div class="tab-content nav-material" id="top-tabContent">
                                    <div class="tab-pane fade" id="top-home" role="tabpanel"
                                        aria-labelledby="top-home-tab">
                                        <p>{{ $productData?->description }}</p>
                                    </div>
                                    <div class="tab-pane fade" id="top-profile" role="tabpanel"
                                        aria-labelledby="profile-top-tab">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                            Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                            unknown printer took a galley of type and scrambled it to make a type specimen
                                            book. It has survived not only five centuries, but also the leap into electronic
                                            typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                            with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                            recently with desktop publishing software like Aldus PageMaker including
                                            versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry. Lorem Ipsum has been the industry's standard dummy text
                                            ever since the 1500s, when an unknown printer took a galley of type and
                                            scrambled it to make a type specimen book. It has survived not only five
                                            centuries, but also the leap into electronic typesetting, remaining essentially
                                            unchanged. It was popularised in the 1960s with the release of Letraset sheets
                                            containing Lorem Ipsum passages, and more recently with desktop publishing
                                            software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    </div>
                                    <div class="tab-pane fade" id="top-contact" role="tabpanel"
                                        aria-labelledby="contact-top-tab">
                                    </div>
                                    <div class="tab-pane fade active show" id="top-review" role="tabpanel"
                                        aria-labelledby="review-top-tab">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="ratio_square product p-details mb-5">
                <div class="container">
                    <h2>Related Products</h2>
                    <div class="row">
                        <div class="col pr-0">
                            <div class="product-slide-6 product-m no-arrow">
                                @include('frontend.components.related-products')
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/frontend/js/countdown.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/image-zoom.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/fancybox.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/scrollup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/custom.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/cart.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/wishlist.js') }}"></script>
@endpush
