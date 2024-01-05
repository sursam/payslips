@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
    <section class="inner-page-banner">
        <h3>Welcome to My Blog
        </h3>
    </section>

    <section class="blog-sec mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    @forelse ($listBlogs as $blog)
                        <div class="blog_boxf">
                            <img src="{{ $blog->display_image }}" class="img-fluid" alt="Blog Image">
                            <div class="blogbox-body">
                                <h2 class="blogbox-title"><a href="{{ route('frontend.blogs.details', $blog->uuid) }}">{{ ucfirst($blog->title) }}</a></h2>
                                <p class="blogbox-text">{{ $blog->description != '' ? substr(strip_tags($blog->description), 0, 500) . '...' : '---' }}</p>
                            </div>
                        </div>
                    @empty
                        <div>
                            <h4>No Blogs Found !!</h4>
                            </div>
                    @endforelse
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
    <script src="{{ asset('assets/frontend/js/blog.js') }}"></script>
@endpush
