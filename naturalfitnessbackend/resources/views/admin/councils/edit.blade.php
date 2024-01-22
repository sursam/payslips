@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Update Council') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.users.council.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">
        
        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Add User Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.users.council.edit',$userData->uuid) }}" id="usersubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('First Name') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="first_name" class="form-control form-control-user @error('first_name') is-invalid @enderror" id="name" placeholder="First Name" aria-label="First Name" aria-describedby="basic-addon2" value="{{ $userData->first_name }}">
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
                                <input type="text" required name="last_name" class="form-control form-control-user @error('last_name') is-invalid @enderror" id="name" placeholder="Last Name" aria-label="Last Name" aria-describedby="basic-addon2" value="{{ $userData->last_name }}">
                            </div>
                            @error('last_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Email') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="name" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2" value="{{ $userData->email }}" readonly>
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Logo') }} </label></label>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input form-control-user showOnUpload" data-show-loaction="imageBanner" id="image" aria-describedby="image" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                </div>
                                @if($userData->image)
                                    <div class="form-group text-center col-lg-12">
                                        <img class="img-fluid" height="150" id="showOnUpload" src="{{ $userData->profile_picture }}" alt="">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="role" value="council">
                <button type="submit" class="btn btn-primary mt-4">Save</button>
            </form>
            <!-- END: Add User Form -->
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/editor.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-tagsinput.js') }}"></script>
    <script>
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword']) ? $seo['meta_keyword'] : ''; ?>";
        $('#meta_keyword').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#meta_keyword').tagsinput('add', meta_keyword_values);
    </script>
@endpush
