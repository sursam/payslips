@forelse ($productData->reviews as $review)
    <li>
        <div class="flex items-center mb-2">
            <img class="w-8 h-8 rounded-full mr-3" src="{{ asset('assets/admin/images/applications-image-21.jpg') }}"
                width="32" height="32" alt="User 07" />
            <div>
                <div class="text-sm font-semibold text-slate-800 mb-1">{{ $review->user->full_name }}</div>
                <div class="flex items-center space-x-2">
                    <div class="flex space-x-1 profile-rating">
                        <span class="profile-rating--count">{{$review->overall_rating}}</span>
                        <div class="show-rating-list profile-rating--list">
                            @php ($filledWidth = (($review->overall_rating / 5) * 100))
                            <div class="rating_area">
                                <div class="gray_rating"></div>
                                <div class="filled_rating" style="width: {{ $filledWidth }}%;"></div>
                            </div>
                        </div>
                        {{-- <button>
                            <span class="sr-only">1 star</span>
                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                <path
                                    d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                            </svg>
                        </button>
                        <button>
                            <span class="sr-only">2 stars</span>
                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                <path
                                    d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                            </svg>
                        </button>
                        <button>
                            <span class="sr-only">3 stars</span>
                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                <path
                                    d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                            </svg>
                        </button>
                        <button>
                            <span class="sr-only">4 stars</span>
                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                <path
                                    d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                            </svg>
                        </button>
                        <button>
                            <span class="sr-only">5 stars</span>
                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                <path
                                    d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                            </svg>
                        </button> --}}
                    </div>
                    <!-- Rate -->
                    <div class="inline-flex text-sm font-medium text-amber-600">{{ $review->overall_rating }}</div>
                </div>
            </div>
        </div>
        <div class="text-sm italic">{{ $review->description }}</div>
    </li>
@empty
    <li>No Review yet</li>
@endforelse
