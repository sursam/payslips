@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Add Driver') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ url()->previous() }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Add Driver Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.driver.add') }}" id="usersubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('First Name') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="first_name" class="form-control form-control-user @error('first_name') is-invalid @enderror"
                                    id="name" placeholder="First Name" aria-label="First Name" aria-describedby="basic-addon2" value="{{ old('first_name') }}">
                            </div>
                            @error('first_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Last Name') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="last_name" class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                    id="name" placeholder="Last Name" aria-label="Last Name" aria-describedby="basic-addon2" value="{{ old('last_name') }}">
                            </div>
                            @error('last_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Mobile Number') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="mobile_number" class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                                    id="name" placeholder="Mobile Number" aria-label="Mobile Number" aria-describedby="basic-addon2" value="{{ old('mobile_number') }}">
                            </div>
                            @error('mobile_number')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Email') }} </label></label>
                            <div class="input-group">
                                <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                    id="name" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2" value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Profile Photo') }} </label></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input form-control-user showOnBrowse" data-show-loaction="profilePhoto" id="image" aria-describedby="image" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                </div>
                                <div class="form-group text-center col-lg-12">
                                    <img class="img-fluid" width="150" height="150" id="profilePhoto" src="{{ asset('assets/images/user.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6"></div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Aadhar Card Front') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="aadhar_front" class="custom-file-input form-control-user showOnBrowse" data-show-loaction="aadharFront" id="aadhar_front" aria-describedby="aadhar_front" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                </div>
                                <div class="form-group text-center col-lg-12">
                                    <img class="img-fluid" width="150" height="150" id="aadharFront" src="{{ asset('assets/images/no-image.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Aadhar Card Back') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="aadhar_back" class="custom-file-input form-control-user showOnBrowse" data-show-loaction="aadharBack" id="aadhar_back" aria-describedby="aadhar_back" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                </div>
                                <div class="form-group text-center col-lg-12">
                                    <img class="img-fluid" width="150" height="150" id="aadharBack" src="{{ asset('assets/images/no-image.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Driving Licence Front') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="licence_front" class="custom-file-input form-control-user showOnBrowse" data-show-loaction="licenceFront" id="licence_front" aria-describedby="licence_front" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                </div>
                                <div class="form-group text-center col-lg-12">
                                    <img class="img-fluid" width="150" height="150" id="licenceFront" src="{{ asset('assets/images/no-image.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Driving Licence Back') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="licence_back" class="custom-file-input form-control-user showOnBrowse" data-show-loaction="licenceBack" id="licence_back" aria-describedby="licence_back" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                </div>
                                <div class="form-group text-center col-lg-12">
                                    <img class="img-fluid" width="150" height="150" id="licenceBack" src="{{ asset('assets/images/no-image.png') }}" alt="">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" name="role" value="driver">
                <button type="submit" class="btn btn-primary mt-4">Save & Next</button>
            </form>
            <!-- END: Add Driver Form -->
        </div>
    </div>

@endsection

@push('scripts')
@endpush
