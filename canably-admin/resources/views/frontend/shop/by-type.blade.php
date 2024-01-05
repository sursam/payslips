@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
    @php
        $collection = collect($data);
    @endphp
    <section class="shop-section">
        <div class="container">
            <div class="shop-header-section">
                <div class="brd-cam">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>/</li>
                        <li><a href="{{ url()->current() }}">Shop</a></li>
                    </ul>
                </div>
                <h2>Canably Marketplace Products</h2>
            </div>
            <div class="row">
                <div class="col-lg-8 col-sm-8 col-12">
                    <div class="shop-inner-row">
                        <div class="upper-row">
                            <div class="row align-items-end">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    Sort by
                                    <select class="form-select orderBy" aria-label="Default select example" name="orderBy">
                                        <option selected value="newest">Newest</option>
                                        <option value="hightolow">Price(High to Low)</option>
                                        <option value="lowtohigh">Price(Low to High)</option>
                                    </select>
                                </div>
                                <div class="col-lg-6  col-md-6 col-sm-12 col-12">
                                    <div class="row upper_right">
                                        <div class="col-lg-7 col-sm-6 col-12">
                                            <div class="show-drp">
                                                <select class="form-select paginate" aria-label="Default select example"
                                                    name="paginate">
                                                    <option selected value="12">Show 12</option>
                                                    <option value="15">Show 15</option>
                                                    <option value="20">Show 20</option>
                                                    <option value="30">Show 30</option>
                                                    <option value="50">Show 50</option>
                                                    <option value="60">Show 60</option>
                                                    <option value="80">Show 80</option>
                                                    <option value="100">Show 100</option>
                                                    <option value="150">Show 150</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-sm-6 col-12">
                                            <div class="scn-icon">
                                                <ul>
                                                    <li id="grid_btn"> <i class="fa fa-th" aria-hidden="true"></i> </li>
                                                    <li id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  product grid view structure  --}}
                        <div class="row product_grid_view">
                            @include('frontend.shop.partials.product', ['products' => $products])
                        </div>
                        {{--  product list view structure  --}}
                        <div class="product_list_view">
                            @include('frontend.shop.partials.product-horizontal', [
                                'products' => $products,
                            ])
                        </div>
                        {{--  product list view structure end  --}}
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-12">
                    <div class="shop-right-part">
                        <form class="" id="productFilterForm">
                            @include('frontend.shop.partials.filter', ['datas' => $collection])
                            @include('frontend.shop.partials.range')
                            <a href="{{ app()->router->has('frontend.shop.by.type') ? route('frontend.shop.by.type', 'all') : 'javascript:void(0)' }}"
                                class="btn btn-primary">Reset</a>
                            {{-- @include('frontend.shop.partials.time-box') --}}
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{ asset('assets/frontend/js/cart.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/wishlist.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/filter.js') }}"></script>
@endpush
