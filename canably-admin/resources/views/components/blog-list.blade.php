@forelse ($listPopularBlogs as $blog)
    <div class="h-card-custom">
        <div class="img">
            <img src="{{ $blog->display_image }}" alt="">
        </div>

        <div class="info">
            <h4>{{ ucfirst($blog->title) }}</h4>
            <p>{{ $blog->description != '' ? substr(strip_tags($blog->description), 0, 130) . '...' : '---' }}
            </p>
            <a href="{{ route('frontend.blogs.details', $blog->uuid) }}">Read more...</a>
        </div>
    </div>
@empty
    <div>
        <h4>No Blogs Found !!</h4>
    </div>
@endforelse
