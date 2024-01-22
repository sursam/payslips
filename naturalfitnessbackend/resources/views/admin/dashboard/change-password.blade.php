@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Change Password') }}
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
            <!-- BEGIN: Change Password -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                action="{{ route('admin.change.password') }}" id="categorysubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5">
                        <div>
                            <label for="change-password-form-1" class="form-label">{{ __('Old Password') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3 show_hide_password">
                                <input id="change-password-form-1" type="password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Old Password" aria-label="Old Password" aria-describedby="basic-addon2" name="current_password">
                                <div class="input-group-append">
                                    <a href="javascript:void(0)" class="input-group-text text-decoration-none">
                                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            @error('current_password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="change-password-form-2" class="form-label">{{ __('New Password') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3 show_hide_password">
                                <input id="change-password-form-2" type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="New Password" aria-label="New Password"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <a href="javascript:void(0)" class="input-group-text text-decoration-none">
                                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="change-password-form-3" class="form-label">{{ __('Confirm New Password') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3 show_hide_password">
                                <input id="change-password-form-3" type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Confirm New Password" aria-label="Confirm New Password"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <a href="javascript:void(0)" class="input-group-text text-decoration-none">
                                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Change Password</button>
                    </div>
                </div>
            </form>
            <!-- END: Change Password -->
        </div>
    </div>

@endsection


@push('scripts')
@endpush
