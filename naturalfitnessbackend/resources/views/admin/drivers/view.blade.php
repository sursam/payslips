@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link href="{{ asset('assets/css/lightbox.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            <span>{{ __('Driver Informations') }}</span>
            <a href="{{ route('admin.driver.edit', $userData->uuid) }}" class="btn-sm">
                <span class="icon text-white-50">
                    <i class="fas fa-pencil"></i>
                </span>
                <span class="text">Edit</span>
            </a>
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
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 sm:w-24 flex-none lg:w-32 image-fit relative">
                    @if($userData->image)
                        <div class="text-center mb-2">
                            <img class="img-fluid" height="150" id="showOnUpload" src="{{ $userData->profile_picture }}">
                        </div>
                        <div class="text-center">
                            @if($userData->is_registered)
                                @if(!$userData->mediaStatus('image'))
                                    <a href="javascript:void(0);" class="btn btn-warning btn-icon-split mr-2 changeMediaStatus" data-user-uuid="{{ $userData->uuid }}" data-media-type="image">
                                        <span class="text">Approve</span>
                                    </a>
                                @else
                                    <span class="approved">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        Approved
                                    </span>
                                @endif
                            @endif
                        </div>
                    @else
                        <img class="img-fluid" height="150" id="showOnUpload" src="{{ asset('assets/images/profile-15.jpg') }}" alt="">
                    @endif

                    {{--  <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2"> <i class="w-4 h-4 text-white" data-lucide="camera"></i> </div>  --}}
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">
                        {{ $userData->first_name . ' ' . $userData->last_name }}
                        {{--  @if($userData->isOnline())
                            <div class="text-success">Online</div>
                        @else
                            <div class="text-slate-500">Offline</div>
                        @endif  --}}
                    </div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="phone" class="w-4 h-4 mr-2"></i> {{ $userData->mobile_number }} </div>
                    @if($userData->email)
                        <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $userData->email }} </div>
                    @endif
                </div>
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
                            {{ __('Aadhar Card') }}
                        </h2>
                        <div class="text-right">
                            @if($userData->is_registered)
                                @if(!$userData->mediaStatus('aadhar_front'))
                                    <a href="javascript:void(0);" class="btn btn-warning btn-icon-split mr-2 changeMediaStatus" data-user-uuid="{{ $userData->uuid }}" data-media-type="aadhar">
                                        <span class="text">Approve</span>
                                    </a>
                                @else
                                    <span class="approved">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        Approved
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-col sm:flex-row">
                            <div class="flex">
                                <div class="grid grid-cols-12 gap-6">
                                    <div class="col-span-12 lg:col-span-6">
                                        <a href="{{ $userData->userDocument('aadhar_front') }}" data-lightbox="adhar-card" data-title="Aadhar Card Front"><img class="img-fluid" id="aadharFront" src="{{ $userData->userDocument('aadhar_front') }}" alt=""></a>
                                    </div>
                                    <div class="col-span-12 lg:col-span-6">
                                        <a href="{{ $userData->userDocument('aadhar_back') }}" data-lightbox="adhar-card" data-title="Aadhar Card Back"><img class="img-fluid" id="aadharBack" src="{{ $userData->userDocument('aadhar_back') }}" alt=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="intro-y box col-span-12 lg:col-span-6">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            {{ __('Driving Licence') }}
                        </h2>
                        <div class="text-right">
                            @if($userData->is_registered)
                                @if(!$userData->mediaStatus('licence_front'))
                                    <a href="javascript:void(0);" class="btn btn-warning btn-icon-split mr-2 changeMediaStatus" data-user-uuid="{{ $userData->uuid }}" data-media-type="licence">
                                        <span class="text">Approve</span>
                                    </a>
                                @else
                                    <span class="approved">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        Approved
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-col sm:flex-row">
                            <div class="flex">
                                <div class="grid grid-cols-12 gap-6">
                                    <div class="col-span-12 lg:col-span-6">
                                        <a href="{{ $userData->userDocument('licence_front') }}" data-lightbox="driving-licence" data-title="Driving Licence Front"><img class="img-fluid" id="licenceFront" src="{{ $userData->userDocument('licence_front') }}" alt=""></a>
                                    </div>
                                    <div class="col-span-12 lg:col-span-6">
                                        <a href="{{ $userData->userDocument('licence_back') }}" data-lightbox="driving-licence" data-title="Driving Licence Back"><img class="img-fluid" id="licenceBack" src="{{ $userData->userDocument('licence_back') }}" alt=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Card Information -->
            </div>
        </div>
    </div>
    <!-- END: Driver Info -->

    @if($userData->vehicle)
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                <span>{{ __('Vehicle Informations') }}</span>
                <a href="{{ route('admin.driver.vehicle', $userData->uuid) }}" class="btn-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-pencil"></i>
                    </span>
                    <span class="text">Edit</span>
                </a>
            </h2>
            <div class="text-right">
            </div>
        </div>
        <!-- BEGIN: Driver Info -->
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">
                        <h2 class="font-medium text-base mr-auto">
                            {{ __('Vehicle Number: ') }}
                        </h2>
                    </div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        {{ $userData->vehicle?->registration_number }}
                    </div>
                </div>
                <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">
                        <h2 class="font-medium text-base mr-auto">
                            {{ __('Vehicle Type: ') }}
                        </h2>
                    </div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        {{ $userData->vehicle?->vehicleType?->name }}
                        @if($userData?->vehicle?->vehicleType?->slug == 'truck')
                            <br> {{  $userData?->vehicle?->vehicleSubType?->name .' ( '.$userData?->vehicle?->vehicleBodyType?->name.' )' }}
                        @endif
                    </div>
                </div>
                {{-- <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">
                        <h2 class="font-medium text-base mr-auto">
                            {{ __('Vehicle Company: ') }}
                        </h2>
                    </div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        {{ $userData->vehicle?->vehicleCompany->name }}
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="intro-y tab-content mt-5">
            <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
                <div class="grid grid-cols-12 gap-6">
                    <div class="intro-y box col-span-8 lg:col-span-8">
                        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                {{ __('RC Image') }}
                            </h2>
                            <div class="text-right">
                                @if($userData->is_registered)
                                    @if(!$userData->mediaStatus('rc_front'))
                                        <a href="javascript:void(0);" class="btn btn-warning btn-icon-split mr-2 changeMediaStatus" data-user-uuid="{{ $userData->uuid }}" data-media-type="rc">
                                            <span class="text">Approve</span>
                                        </a>
                                    @else
                                        <span class="approved">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            Approved
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex flex-col sm:flex-row">
                                <div class="flex">
                                    <div class="grid grid-cols-12 gap-6">
                                        <div class="col-span-12 lg:col-span-6">
                                            <a href="{{ $userData->vehicle?->vehicleDocument('rc_front') }}" data-lightbox="rc-image" data-title="RC Front"><img class="img-fluid" id="rcFront" src="{{ $userData->vehicle?->vehicleDocument('rc_front') }}" alt=""></a>
                                        </div>
                                        <div class="col-span-12 lg:col-span-6">
                                            <a href="{{ $userData->vehicle?->vehicleDocument('rc_back') }}" data-lightbox="rc-image" data-title="RC Back"><img class="img-fluid" id="rcBack" src="{{ $userData->vehicle?->vehicleDocument('rc_back') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="intro-y box col-span-4 lg:col-span-4">
                        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                {{ __('Vehicle Image') }}
                            </h2>
                            <div class="text-right">
                                @if($userData->is_registered)
                                    @if(!$userData->mediaStatus('vehicle_image'))
                                        <a href="javascript:void(0);" class="btn btn-warning btn-icon-split mr-2 changeMediaStatus" data-user-uuid="{{ $userData->uuid }}" data-media-type="vehicle_image">
                                            <span class="text">Approve</span>
                                        </a>
                                    @else
                                        <span class="approved">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            Approved
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex flex-col sm:flex-row">
                                <div class="flex">
                                    <div class="grid grid-cols-12 gap-6">
                                        <div class="col-span-12 lg:col-span-12">
                                            <a href="{{ $userData->vehicle?->vehicleDocument('vehicle_image') }}" data-lightbox="vehicle-image" data-title="Vehicle image"><img class="img-fluid" id="vehicle_image" src="{{ $userData->vehicle?->vehicleDocument('vehicle_image') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/lightbox.js') }}"></script>
    <script>
        lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true
        })
    </script>
@endpush
