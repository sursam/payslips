@forelse ($listTestimonials  as $testimonial)
    <div>
        <div class="testimonial-box">
            <div class="img-wrapper"> <img src="{{ $testimonial->display_image }}" alt="testimonial"
                    class="img-fluid"> </div>
            <div class="testimonial-detail">
                <h4>{{ $testimonial->product }}</h4>
                {{-- <ul>
                    @php
                        $rating = $testimonial->overall_rating;
                    @endphp
                    @for ($i = 1; $i <= $rating; $i++)
                        <li><i class="fa fa-star"></i></li>
                    @endfor
                </ul> --}}
                <p>{!! $testimonial->comment !!}</p>
                <h3>{{ $testimonial->name }}
                </h3>
                {{-- <h6>pet trainers</h6> --}}
            </div>
        </div>
    </div>
@empty

    <div>{{ 'No Data Found' }}</div>

@endforelse
