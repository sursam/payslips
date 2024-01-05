@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
    <section class="faq_sec">
        <div class="faq_sechead" @if ($banner)
            style="background-image: url({{ $banner->display_image }})"
        @endif >
            <h3>{{ $pageContent->name }}</h3>
        </div>
        <div class="container">
            <div class="faq_contentbox">
                {{-- <h2 class="faq_title">{{ $pageContent->name }}</h2> --}}
                {!! html_entity_decode($pageContent->description) !!}
            </div>
        </div>
    </section>

    {{-- for become a driver page --}}
@endsection
@push('scripts')
    <script src="//maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>
    <script src="{{ asset('assets/frontend/js/map.js') }}"></script>
@endpush
