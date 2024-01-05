@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
    @if ($type == 'brand')
        <div class="container">
            <div class="our-band">
                <h2>Discover Our Selection of Brands</h2>
                <div class="our-band-inner">
                    <div class="row row-cols-lg-5">
                        @forelse ($data as $brand)
                            <div class="col">
                                <div class="our-banner-box-outer">
                                    <div class="our-banner-box">
                                        <div class="row align-items-center">
                                            <div class="our-banner-box-icon col-lg-5"> <img src="{{ $brand->display_image }}"
                                                    alt="">
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
        </div>
    @endif
    @if ($type == 'category')
        <section class="instagram mt-4">
            <div class="container">
                <div class="row">
                    <h2>Our Product Categories</h2>
                    <div class="col p-0 position-relative">
                        <div class="insta-contant1 ">
                            <div class="slide-2 type_list no-arrow">
                                @forelse ($data as $category)
                                    <div class="typelist_box">
                                        <div class="instagram-box cata_box">
                                            <a href="{{ route('frontend.shop.by.category', $category->slug) }}"><img
                                                    src="{{ $category->display_image }}" class="img-fluid"
                                                    alt="insta"></a>
                                            <p>{{ $category->name }}</p>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
@push('scripts')
@endpush
