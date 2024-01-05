@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
    <section class="store_locator">
        <div class="store_img">
            <img src="{{ asset('assets/frontend/images/store-img.jpg') }}" class="img-fluid" alt="contact-img">
            <div class="storei_con">
                <h3>Store Locator</h3>
            </div>
        </div>
        <div class="container-fluid p-0">
           {{--  <div class="store_img">
                <img src="{{ asset('assets/frontend/images/store-img.jpg') }}" class="img-fluid" alt="contact-img">
                <div class="storei_con">
                    <h3>See Where You Can Get Your Favorite Products</h3>
                </div>
            </div> --}}

            <input type="hidden" class="locations" value="{{ json_encode($data) }}">
            <div class="location_box row">
                @forelse ($data as $store)
                    <div class="card col-md-3 my-auto p-3 card_store">
                        <span class="fw-bold">{{ $store['name'] }}</span>
                        <div>
                            <span class="fw-bold">Address:-</span>
                            <span class="text-info">{!! $store['address'] !!}</span>
                        </div>
                    </div>
                @empty
                    <p>No Stores Available</p>
                @endforelse

            </div>
            {{-- <div class="location_box">
                <label for="">Your Location</label>
                <input type="text" class="form-control">
                <label for="">Search radius</label>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <label for="">Results</label>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <button type="submit" class="btn">Search</button>
            </div> --}}
            <div class="my-2"></div>
            <div id="map" class="col-lgh-12 w-100" style="width: 500px;height:550px;"></div>
        </div>
    </section>
@endsection
@push('scripts')
    <script async src="//maps.googleapis.com/maps/api/js?key={{ config('constants.GOOGLE_MAP_KEY') }}&callback=initMap"></script>
    <script src="{{ asset('assets/frontend/js/map.js') }}"></script>
@endpush
