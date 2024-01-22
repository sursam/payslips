@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Add Module') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.grant.settings.module.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Add Page Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                action="{{ route('admin.grant.settings.module.add') }}" id="pagesubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5">
                        <div>
                            <label for="title-form-1" class="form-title">{{ __('Title') }} <span
                                    class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group mb-3">
                                <input type="text" name="title"
                                    class="form-control form-control-user @error('title') is-invalid @enderror"
                                    id="title" placeholder="Title" aria-label="title"
                                    aria-describedby="basic-addon2">
                            </div>
                            @error('title')
                                <span class="invalid-feedback d-block text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Add</button>
            </form>
            <!-- END: Add Page Form -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/editor.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('assets/js/grant.js') }}"></script>
    <script>
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword']) ? $seo['meta_keyword'] : ''; ?>";
        $('#meta_keyword').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#meta_keyword').tagsinput('add', meta_keyword_values);
    </script>
@endpush
