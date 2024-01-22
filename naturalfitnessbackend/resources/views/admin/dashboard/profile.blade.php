@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('My Account') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.home') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-home"></i>
                </span>
                <span class="text ml-2">Go Home</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Profile Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.profile') }}" id="profilesubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="first-name-form-1" class="form-label">{{ __('First Name') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="first_name" class="form-control form-control-user @error('first_name') is-invalid @enderror"
                                    id="first_name" placeholder="First Name" aria-label="First Name" aria-describedby="basic-addon2"
                                    value="{{ auth()->user()->first_name }}">
                            </div>
                            @error('first_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="last-name-form-1" class="form-label">{{ __('Last Name') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="last_name" class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                    id="last_name" placeholder="Last Name" aria-label="Last Name" aria-describedby="basic-addon2"
                                    value="{{ auth()->user()->last_name }}">
                            </div>
                            @error('last_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="username-form-1" class="form-label">{{ __('Username') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="username" class="form-control form-control-user @error('username') is-invalid @enderror"
                                    id="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon2"
                                    value="{{ auth()->user()->username }}" readonly>
                            </div>
                            @error('username')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="email-form-1" class="form-label">{{ __('Email') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                    id="email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2"
                                    value="{{ auth()->user()->email }}" readonly>
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="mobile-number-form-1" class="form-label">{{ __('Mobile Number') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="mobile_number" class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                                    id="mobile_number" placeholder="Mobile Number" aria-label="Mobile Number" aria-describedby="basic-addon2"
                                    value="{{ auth()->user()->mobile_number }}">
                            </div>
                            @error('mobile_number')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="gender-form-1" class="form-label">{{ __('Gender') }} </label></label>
                            <div class="input-group">
                                <select name="gender" id="gender" class="form-control form-control-user">
                                    <option value="">Select Gender</option>
                                    <option value="male" @selected(auth()->user()->profile->gender=='male')>Male</option>
                                    <option value="female" @selected(auth()->user()->profile->gender=='female')>Female</option>
                                    <option value="transgender" @selected(auth()->user()->profile->gender=='transgender')>Transgender</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="birthday-form-1" class="form-label">{{ __('Birthday') }} </label></label>
                            <div class="input-group">
                                <input type="date" name="birthday" class="form-control form-control-user" id="birthday" value="{{ auth()->user()->profile->birthday }}" aria-label="Birthday" aria-describedby="basic-addon2">
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                            <button type="submit" class="btn btn-primary mt-4">Save</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END: Profile Form -->
        </div>
    </div>

@endsection


@push('scripts')
@endpush
