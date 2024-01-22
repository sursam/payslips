@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Add Fare') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.fare.list') }}" class="btn btn-warning btn-icon-split">
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
                action="{{ route('admin.fare.add') }}" id="pagesubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5">
                        <div>
                            <label for="name-form-1" class="form-label">{{ __('Vehicle Type') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <select name="category_id" class="form-control" required>
                                    <option value="">---Select---</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <label for="title-form-1" class="form-label">{{ __('Start Time') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="text" required name="start_at"
                                    class="form-control form-control-user @error('title') is-invalid @enderror"
                                    id="title" placeholder="Start Time" aria-label="Start Time"
                                    aria-describedby="basic-addon2">
                            </div>
                            @error('title')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description-form-1" class="form-label">{{ __('End Time') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="col-sm-12">
                                <input type="text" required name="end_at"
                                    class="form-control form-control-user @error('title') is-invalid @enderror"
                                    id="title" placeholder="End Time" aria-label="End Time"
                                    aria-describedby="basic-addon2">
                            </div>
                            @error('description')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description-form-1" class="form-label">{{ __('Rate/Km') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="col-sm-12">
                                <input type="text" required name="amount"
                                    class="form-control form-control-user @error('title') is-invalid @enderror"
                                    id="title" placeholder="Rate" aria-label="Rate" aria-describedby="basic-addon2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            </div>
                            @error('description')
                                <span class="invalid-feedback d-block" role="alert">
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword']) ? $seo['meta_keyword'] : ''; ?>";
        $('#meta_keyword').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#meta_keyword').tagsinput('add', meta_keyword_values);
        $(document).ready(function() {
            $('input.timepicker').timepicker({});
        });
    </script>
@endpush
