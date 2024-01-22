@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y items-center mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-6">
            <x-driver-tab :userData=$userData :currentTab=$currentTab />
        </div>
        <div class="col-6 col-span-6 text-right">
            <a href="{{ route('admin.driver.list', $userData->vehicle?->vehicleType?->slug) }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Add Vehicle Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.driver.vehicle', $userData->uuid) }}" id="usersubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Vehicle Number') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="registration_number" class="form-control form-control-user @error('registration_number') is-invalid @enderror"
                                    id="name" placeholder="Vehicle Number" aria-label="Vehicle Number" aria-describedby="basic-addon2" value="{{ $vehicleData->registration_number }}">
                            </div>
                            @error('registration_number')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Vehicle Type') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <select class="form-control select2bs4 getMultiPopulate" name="category_id"
                                data-location-first="sub_category_id" data-message-first="Sub Type" data-location-second="body_type_id" data-message-second="Sub Body Type" id="category_id">
                                <option value="">Select Type</option>
                                @forelse ($vehicleTypes as $vehicleType)
                                    <option value="{{ $vehicleType->uuid }}"
                                        @selected($vehicleData->category_id == $vehicleType->id)
                                        data-populate-first="{{ json_encode($vehicleType->vehilcleSubTypes->pluck('name', 'uuid')) }}"
                                        data-populate-second="{{ json_encode($vehicleType->vehilcleBodyTypes->pluck('name', 'uuid')) }}">
                                        {{ $vehicleType->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            </div>
                            @error('category_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        {{-- <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Vehicle Company') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <select class="form-control select2bs4" name="company_id"
                                data-message="Vehicle Company" id="company_id">
                                <option value="">Select Company</option>
                                @forelse ($vehicleCompanies as $vehicleCompany)
                                    <option value="{{ $vehicleCompany->uuid }}"
                                        @selected($vehicleData->company_id == $vehicleCompany->id)>
                                        {{ $vehicleCompany->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            </div>
                            @error('company_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">

                            <label for="name-form-1" class="form-label">{{ __('Vehicle Sub Type') }} </label>
                            <div class="input-group">
                                <select name="sub_category_id" id="sub_category_id"
                                    data-auth="{{ $vehicleData->vehicleSubType?->uuid }}" class="form-control sub_category_id">
                                    <option value="">Select Sub Type</option>
                                </select>
                            </div>
                            @error('sub_category_id')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Vehicle Body Type') }} </label>
                            <div class="input-group">
                                <select name="body_type_id" id="body_type_id"
                                    data-auth="{{ $vehicleData->vehicleBodyType?->uuid }}" class="form-control body_type_id">
                                    <option value="">Select Body Type</option>
                                </select>
                            </div>
                            @error('body_type_id')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Helper Count') }} </label></label>
                            <div class="input-group">
                                <input type="number" name="helper_count" class="form-control form-control-user @error('helper_count') is-invalid @enderror"
                                    id="name" placeholder="Helper Count" aria-label="Helper Count" aria-describedby="basic-addon2" value="{{ $vehicleData->helper_count }}">
                            </div>
                            @error('helper_count')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Upload Vehicle Image') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="vehicle_image" class="custom-file-input form-control-user showOnBrowse" data-show-loaction="vehicle_image" id="backImage" aria-describedby="image" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                </div>
                                @if($vehicleData->vehicleDocument('vehicle_image'))
                                    <div class="form-group text-center col-lg-12">
                                        <img class="img-fluid" width="150" height="150" id="vehicle_image" src="{{ $vehicleData->vehicleDocument('vehicle_image') }}" alt="">
                                    </div>
                                @endif
                            </div>
                            @error('vehicle_image')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Upload RC Front') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="rc_front" class="custom-file-input form-control-user showOnBrowse" data-show-loaction="profilePhoto" id="image" aria-describedby="image" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                </div>
                                @if($vehicleData->vehicleDocument('rc_front'))
                                    <div class="form-group text-center col-lg-12">
                                        <img class="img-fluid" width="150" height="150" id="profilePhoto" src="{{ $vehicleData->vehicleDocument('rc_front') }}" alt="">
                                    </div>
                                @endif
                            </div>
                            @error('rc_front')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Upload RC Back') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="rc_back" class="custom-file-input form-control-user showOnBrowse" data-show-loaction="rcBackPhoto" id="backImage" aria-describedby="image" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                </div>
                                @if($vehicleData->vehicleDocument('rc_back'))
                                    <div class="form-group text-center col-lg-12">
                                        <img class="img-fluid" width="150" height="150" id="rcBackPhoto" src="{{ $vehicleData->vehicleDocument('rc_back') }}" alt="">
                                    </div>
                                @endif
                            </div>
                            @error('rc_back')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>
                {{--  <input type="hidden" name="user_id" value="{{ $userData->uuid }}">  --}}
                <button type="submit" class="btn btn-primary mt-4">Save</button>
            </form>
            <!-- END: Add Vehicle Form -->
        </div>
    </div>

@endsection

@push('scripts')
@endpush
