@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link href="{{ asset('assets/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Add Zone') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.settings.zone.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Add Zone Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                action="{{ route('admin.settings.zone.add') }}" id="zonesubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5">
                        <div>
                            <label for="name-form-1" class="form-label">{{ __('Zone Name') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="text" required name="name"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="name" placeholder="Zone Name" aria-label="Zone Name"
                                    aria-describedby="basic-addon2">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <label for="name-form-1" class="form-label">{{ __('Post Codes') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="text" required name="postcodes[codes]"
                                    class="form-control form-control-user @error('postcodes.codes') is-invalid @enderror"
                                    id="postcodes" placeholder="Post Codes" aria-label="Zone Post codes"
                                    aria-describedby="basic-addon2">
                            </div>
                            @error('postcodes.codes')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Add</button>
            </form>
            <!-- END: Add Zone Form -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/bootstrap-tagsinput.js') }}"></script>
    <script>
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword']) ? $seo['meta_keyword'] : ''; ?>";
        $('#postcodes').tagsinput({
            confirmKeys: [13, 32, 44],
            allowDuplicates: false
        });
        $('#postcodes').tagsinput('add', meta_keyword_values);
    </script>
@endpush
