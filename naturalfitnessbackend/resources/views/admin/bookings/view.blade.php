@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link href="{{ asset('assets/css/lightbox.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            <span>{{ __('Booking Informations') }}</span>
        </h2>
        <div class="text-right">
            <a href="{{ url()->previous() }}" class="btn btn-warning btn-icon-split mr-2">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <!-- BEGIN: Driver Info -->
    <div class="intro-y px-5 pt-5 mt-5">
        <div class="flex flex-col pb-5 -mx-5">
            <div class="track">
                <div class="step status_arrow @if ($bookingData->status==0) active @endif @if ($bookingData->status > 0) done @endif">
                    <a href="#">
                        <span class="icon">
                            BOOKED
                        </span>
                    </a>
                </div>
                <div class="step status_arrow @if ($bookingData->status==1) active @endif @if ($bookingData->status > 1) done @endif">
                    <a href="#">
                        <span class="icon">
                            ACCEPTED
                        </span>
                    </a>
                </div>
                @if ($bookingData->status == 2)
                    <div class="step status_arrow @if ($bookingData->status==2) active @endif">
                        <a href="#">
                            <span class="icon">
                                CANCELLED
                            </span>
                        </a>
                    </div>
                @else
                    <div class="step status_arrow @if ($bookingData->status==3) active @endif @if ($bookingData->status > 3) done @endif">
                        <a href="#">
                            <span class="icon">
                                ON TRIP
                            </span>
                        </a>
                    </div>
                    <div class="step status_arrow @if ($bookingData->status==4) active @endif @if ($bookingData->status > 4) done @endif">
                        <a href="#">
                            <span class="icon">
                                COMPLETED
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                @if($bookingData->bookingDriver)
                    <div class="w-20 sm:w-24 flex-none lg:w-32 image-fit relative">
                        <div class="text-center mb-2">
                            <a href="{{ $bookingData->bookingDriver?->driver?->vehicle->vehicleDocument('vehicle_image') }}" data-lightbox="vehicle-image" data-title="Vehicle Image"><img class="img-fluid" height="150" id="showOnUpload" src="{{ $bookingData->bookingDriver?->driver?->vehicle->vehicleDocument('vehicle_image') }}"></a>
                        </div>
                    </div>
                @endif
                <div class="ml-5">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <i data-lucide="car" class="w-4 h-4 mr-2"></i> {{ $bookingData->vehicleType->name }}
                        @if($bookingData->bookingDriver)
                            ( {{ $bookingData->bookingDriver?->driver?->vehicle->registration_number }} )
                        @endif
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-4">
                        <i data-lucide="clock" class="w-4 h-4 mr-2"></i> {{ $bookingData->scheduled_at->format('d/m/Y H:i A') }}
                    </div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3">Booking Details</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    ID: {{ 'NF-' . strtotime($bookingData->created_at) }}
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-2">
                    Amount: {{ '₹ ' . $bookingData->price }}
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y tab-content mt-5">
        <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y box col-span-12 lg:col-span-6">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            {{ __('Locations ') }} {{--  <span>( Distance )</span>  --}}
                        </h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-col sm:flex-row">
                            <div class="flex">
                                <div class="grid grid-cols-12 gap-6">
                                    <div class="col-span-12 lg:col-span-12 distance_box">
                                        <div class="distance-track">
                                            @forelse ($bookingData->addresses as $k => $address)
                                                <div class="distance-track-step">
                                                    <div class="distance-track-status">
                                                        <span class="distance-track-status-dot"></span>
                                                    </div>
                                                    <div class="distance-track-text">
                                                        <p class="from_txt">
                                                            @if($k == 0 ) Pickup @else Drop @endif
                                                        </p>
                                                        <p class="distance-track-text-stat">
                                                            {{ $address->full_address }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @empty

                                            @endforelse

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="intro-y box col-span-12 lg:col-span-6">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            {{ __('Map ') }}
                        </h2>
                    </div>

                    <div class="p-5" id="map"></div>

                </div>
                <!-- END: Card Information -->
            </div>
        </div>
    </div>
    <div class="intro-y tab-content mt-5">
        <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Card Information -->
                <div class="intro-y box col-span-12 lg:col-span-6">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            {{ __('Customer') }}
                        </h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-col sm:flex-row">
                            <div class="flex">
                                <div class="grid grid-cols-12 gap-6">
                                    <div class="col-span-12 lg:col-span-4">
                                        <img class="img-fluid" height="150" id="showOnUpload" src="{{ $bookingData->customer->profile_picture }}">
                                    </div>
                                    <div class="col-span-12 lg:col-span-8">
                                        {{ $bookingData->customer->full_name }}
                                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="phone" class="w-4 h-4 mr-2"></i> {{ $bookingData->customer->mobile_number }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="intro-y box col-span-12 lg:col-span-6">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            {{ __('Driver') }}
                        </h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-col sm:flex-row">
                            <div class="flex">
                                <div class="grid grid-cols-12 gap-6">
                                    @if($bookingData->bookingDriver)
                                        <div class="col-span-12 lg:col-span-4">
                                            <img class="img-fluid" height="150" id="showOnUpload" src="{{ $bookingData->bookingDriver?->driver?->profile_picture }}">
                                        </div>
                                        <div class="col-span-12 lg:col-span-8">
                                            {{ $bookingData->bookingDriver?->driver?->full_name }}
                                            <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="phone" class="w-4 h-4 mr-2"></i> {{ $bookingData->bookingDriver?->driver?->mobile_number }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Card Information -->
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/lightbox.js') }}"></script>
    <script>
        lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
        });

        function initMap() {
            var directionsService = new google.maps.DirectionsService();
            var directionsDisplay = new google.maps.DirectionsRenderer();
            var map;
            var mapCenter = new google.maps.LatLng({{ $bookingData->addresses[0]->latitude }}, {{ $bookingData->addresses[0]->longitude }});

            var mapOptions = {
                zoom: 14,
                center: mapCenter
            }

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            function calculateRoute(mapOrigin, mapDestination) {
                var request = {
                    origin: mapOrigin,
                    destination: mapDestination,
                    travelMode: 'DRIVING'
                };
                directionsService.route(request, function(result, status) {
                    if (status == "OK") {
                    var directionsDisplay = new google.maps.DirectionsRenderer({
                        map: map
                    });
                    directionsDisplay.setDirections(result);
                    }
                });
            }

            const addresses = {!! $bookingData->addresses !!};
            //console.log(addresses);
            addresses.forEach(function callback(value, index) {
                //console.log(addresses.length);
                if((index + 1) < addresses.length){
                    //console.log( addresses[index].latitude, addresses[index].longitude );
                    //console.log( addresses[(index+1)].latitude, addresses[(index+1)].longitude );
                    var mapOrigin = new google.maps.LatLng(addresses[index].latitude, addresses[index].longitude);
                    var mapDestination = new google.maps.LatLng(addresses[(index+1)].latitude, addresses[(index+1)].longitude);
                    calculateRoute(mapOrigin, mapDestination);
                }
            });


        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('constants.GOOGLE_MAP_API_KEY') }}&callback=initMap"></script>
@endpush
