<div class="row">
    @if ($listBlogs->isNotEmpty())
    <div class="col-lg-8  col-md-12 col-sm-12 col-12">
        <div class="blog-row-left">
            <div class="blog-row-left-img"> <a href="{{ route('frontend.blogs.details', $listBlogs->first()?->uuid) }}"><img src="{{ $listBlogs->first()?->display_image }}" alt=""></a>
                <div class="blog-row-text">
                    <h3>{{ $listBlogs->first()?->title }}</h3>
                    <p>{{ date('M d , Y', strtotime($listBlogs->first()?->created_at)) }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-lg-4  col-md-12 col-sm-12 col-12">
        <div class="blog-row-right">
            @forelse ($listBlogs as $blogs)
                <div class="blog-row-right-inner">
                    <div class="row">
                        <div class="blog-row-right-inner-left col-lg-5 col-12"> <a href="{{ route('frontend.blogs.details', $blogs->uuid) }}"><img src="{{ $blogs->display_image }}"
                                alt=""></a>
                        </div>
                        <div class="blog-row-right-inner-right col-lg-7 col-12">
                            <h5><span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                {{ date('M d , Y', strtotime($blogs->created_at)) }}
                            </h5>
                            <a href="{{ route('frontend.blogs.details', $blogs->uuid) }}"><h2>{{ $blogs->title }}</h2></a>
                            <p>{{$blogs->description!=''?substr(strip_tags($blogs->description),0,100).'...':'---' }}</p>
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
