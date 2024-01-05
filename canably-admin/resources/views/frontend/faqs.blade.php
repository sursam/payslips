@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
<section class="faq-section">
    <div class="container">
        <h2 class="section-title">Frequent Asked Questions</h2>
        <!-- Your content goes here -->

        <div class="accordion" id="accordionExample">
            <div class="row">
                @forelse ($listFaqs as $chunk)
                <div class="col-md-6">
                    @forelse ($chunk as $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $faq->uuid }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->uuid }}" aria-expanded="true" aria-controls="collapseOne">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="collapse{{ $faq->uuid }}" class="accordion-collapse collapse @if ($loop->first) show @endif" aria-labelledby="heading{{ $faq->uuid }}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
                @empty
                <div>
                    <h4>No Faqs Found !!</h4 </div>
                    @endforelse
                </div>

            </div>
        </div>
</section>
@endsection
@push('scripts')
<script src="{{ asset('assets/frontend/js/cart.js') }}"></script>
<script src="{{ asset('assets/frontend/js/wishlist.js') }}"></script>
@endpush