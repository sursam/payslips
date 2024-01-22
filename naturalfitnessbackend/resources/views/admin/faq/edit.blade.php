@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Edit FAQ') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.support.faq.list') }}" class="btn btn-warning btn-icon-split">
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
                id="faqsubmit" action="{{ route('admin.support.faq.edit', $faqData->uuid) }}">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5">
                        <div>
                            <label for="name-form-1" class="form-label">{{ __("FAQ's Group") }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <select name="category_id" class="form-control" required>
                                    <option value="">---Select---</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if($category->id == $faqData->category_id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <label for="title-form-1" class="form-label">{{ __('Question') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="text" required name="question"
                                    class="form-control timepicker form-control-user @error('question') is-invalid @enderror"
                                    id="question" placeholder="FAQ Question" aria-label="Start Time"
                                    aria-describedby="basic-addon2" value="{{ $faqData->question }}">
                            </div>
                            @error('question')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description-form-1" class="form-label">{{ __('Answer') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="col-sm-12">
                                {{--  <input type="text" required name="answer"
                                    class="form-control timepicker form-control-user @error('title') is-invalid @enderror"
                                    id="FAQ Answer" placeholder="FAQ Answer" aria-label="End Time"
                                    aria-describedby="basic-addon2" value="{{ $faqData->answer }}">  --}}
                                <textarea required name="answer"
                                class="form-control timepicker form-control-user @error('answer') is-invalid @enderror" id="answer" cols="10" rows="3">{{ $faqData->answer }}</textarea>
                            </div>
                            @error('answer')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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
@endpush
