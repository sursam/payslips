@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Add Application Form') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.grant.settings.form.list') }}" class="btn btn-warning btn-icon-split">
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
                action="{{ url('admin/grant/settings/form/edit', [$uuid]) }}" id="pagesubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5">
                        <div>

                            <label for="type-form-1" class="form-label">{{ __('Type') }} <span
                                    class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group mb-3">
                                <select disabled name="type" id="type"
                                    class="form-control form-control-user @error('type') is-invalid @enderror"
                                    placeholder="type" aria-label="type" aria-describedby="basic-addon2">
                                    <option value="text" {{ trim($applicationForm->type) == 'text' ? 'selected' : '' }}>
                                        Text
                                    </option>
                                    <option value="selectbox"
                                        {{ trim($applicationForm->type) == 'selectbox' ? 'selected' : '' }}>
                                        Select Box</option>
                                    <option value="textarea"
                                        {{ trim($applicationForm->type) == 'textarea' ? 'selected' : '' }}>
                                        Textarea</option>
                                    <option value="number" {{ trim($applicationForm->type) == 'number' ? 'selected' : '' }}>
                                        Number
                                    </option>
                                    <option value="radio" {{ trim($applicationForm->type) == 'radio' ? 'selected' : '' }}>
                                        Radio
                                    </option>
                                    <option value="checkbox"
                                        {{ trim($applicationForm->type) == 'checkbox' ? 'selected' : '' }}>Check
                                        Box</option>
                                    <option value="date" {{ trim($applicationForm->type) == 'date' ? 'selected' : '' }}>
                                        Check
                                        Box</option>
                                </select>
                            </div>
                            @error('type')
                                <span class="invalid-feedback d-block text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label for="question-form-1" class="form-question">{{ __('Label') }} <span
                                    class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group mb-3">
                                <input type="text" name="question"
                                    class="form-control form-control-user @error('question') is-invalid @enderror"
                                    id="question" placeholder="question" aria-label="question"
                                    aria-describedby="basic-addon2" value="{{ $applicationForm->question ?? '' }}">
                            </div>
                            @error('question')
                                <span class="invalid-feedback d-block text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label for="field-form-1" class="form-is_mandatory">{{ __('Is Mandatory') }} <span
                                    class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group mb-3">
                                <select name="is_mandatory" id="is_mandatory"
                                    class="form-control form-control-user @error('is_mandatory') is-invalid @enderror"
                                    placeholder="is_mandatory" aria-label="is_mandatory" aria-describedby="basic-addon2">
                                    <option value="0" {{ trim($applicationForm->type) == 0 ? 'selected' : '' }}>No
                                    </option>
                                    <option value="1" {{ trim($applicationForm->type) == 1 ? 'selected' : '' }}>Yes
                                    </option>
                                </select>
                            </div>
                            @error('is_mandatory')
                                <span class="invalid-feedback d-block text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <label for="place_holder-form-1" class="form-place_holder">{{ __('Place Holder') }} <span
                                    class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group mb-3">
                                <input type="text" name="place_holder"
                                    class="form-control form-control-user @error('place_holder') is-invalid @enderror"
                                    id="place_holder" placeholder="Place Holder" aria-label="place_holder"
                                    aria-describedby="basic-addon2" value="{{ $applicationForm->place_holder ?? '' }}">
                            </div>
                            @error('place_holder')
                                <span class="invalid-feedback d-block text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label for="max_length-form-1" class="form-max_length">{{ __('Max Length') }} <span
                                    class="text-danger"><sup></sup></span></label>
                            <div class="input-group mb-3">
                                <input type="text" name="max_length"
                                    class="form-control number-only form-control-user @error('max_length') is-invalid @enderror"
                                    id="max_length" placeholder="Place Holder" aria-label="max_length"
                                    aria-describedby="basic-addon2" value="{{ $applicationForm->max_length ?? '' }}">
                            </div>
                            @error('max_length')
                                <span class="invalid-feedback d-block text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- <div class="optionBtn"
                            {{ !empty($applicationForm->ApplicationFormOption->toArray()) ? 'style=display:block' : 'style=display:none' }}>
                            <label for="question-form-1" class="form-question">{{ __('Are You add Option ?') }} <span
                                    class="text-danger"><sup></sup></span></label>
                            <div class="input-group mb-3">
                                <div class="form-check">
                                    <input name="option-field" class="form-check-input checkForAddOption" type="checkbox" value=""
                                        id="flexCheckDefault"
                                        {{ $applicationForm->ApplicationFormOption != null ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Clicked Check for add option
                                    </label>
                                </div>
                            </div>
                            @error('question')
                                <span class="invalid-feedback d-block text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}

                        @if ($applicationForm->ApplicationFormOption)
                            <div class="option"
                                {{ !empty($applicationForm->ApplicationFormOption->toArray()) ? 'style=display:block' : 'style=display:none' }}>
                                @foreach ($applicationForm->ApplicationFormOption as $key => $optionValue)
                                    @if ($key == 0)
                                        <div class="grid grid-cols-12 gap-6 p-2"><br>
                                            <input required type="text"
                                                class="form-control col-span-8 lg:col-span-8 2xl:col-span-8" name="option[]"
                                                placeholder="Option Value" value="{{ $optionValue->option_value }}">
                                            <a href="javascript:void(0)"
                                                class="btn btn-sm btn-outline-success col-span-2 lg:col-span-2 2xl:col-span-2 addMore"><i
                                                    class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add More</a>
                                        </div>
                                    @else
                                        <div class="appendDiv grid grid-cols-12 gap-6 p-2"><br><input required
                                                type="text"
                                                class="form-control col-span-8 lg:col-span-8 2xl:col-span-8"
                                                name="option[]" placeholder="Option Value"
                                                value="{{ $optionValue->option_value }}"><a href="javascript:void(0)"
                                                class="btn btn-sm btn-outline-danger col-span-2 lg:col-span-2 2xl:col-span-2 xroxxBtn"><i
                                                    class="fa fa-trash pl-2" aria-hidden="true"></i> &nbsp;Remove</a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        @error('option-field')
                            <span class="invalid-feedback d-block text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        @error('option')
                            <span class="invalid-feedback d-block text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Update</button>
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


        $(document).on("click", ".addMore", function() {
            let innerHtml = '';
            innerHtml =
                `<div class="appendDiv grid grid-cols-12 gap-6 p-2"><br><input type="text" class="form-control col-span-8 lg:col-span-8 2xl:col-span-8" name="option[]" placeholder="Option Value"><a href="javascript:void(0)" class="btn btn-sm btn-outline-danger col-span-2 lg:col-span-2 2xl:col-span-2 xroxxBtn"><i class="fa fa-trash pl-2" aria-hidden="true"></i> &nbsp;Remove</a></div>`;
            $('.option').append(innerHtml);
        });

        $(document).on("click", ".xroxxBtn", function() {
            $(this).closest('div.appendDiv').remove();
        });
    </script>
@endpush
