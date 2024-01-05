@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
    <section class="inner-page-banner">
        <h3>{{ $blogData->title?ucfirst($blogData->title):'' }}
        </h3>
    </section>

    <section class="blog-sec mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                        <div class="card mb-3">
                            <img src="{{ $blogData->display_image }}" class="card-img-top" alt="Blog Image">
                            <div class="card-body">
                                <h2 class="card-title"><a href="javascript:void(0)">{{ $blogData->title?ucfirst($blogData->title):'' }}</a></h2>
                                <p class="card-text">{!! $blogData->description !!}</p>
                            </div>
                        </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3 side-bar-content-scroll">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Popular Posts</h4>
                            <div class="search-container mb-3">
                                <form id="blogSearchForm">
                                    <input type="text" placeholder="Search..." name="search">
                                    <button type="button" class="blogSearchButton"><i class="fa fa-search"></i></button>
                                </form>
                            </div>

                            <div class="popularpost-sec">
                                @include('components.blog-list',['listPopularBlogs'=>$listPopularBlogs])
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/frontend/js/cart.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/wishlist.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/blog.js') }}"></script>
@endpush
