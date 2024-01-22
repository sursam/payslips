@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush
@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Add Issue') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.medical.issue.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Add Issue Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                action="{{ route('admin.medical.issue.add') }}" id="issuesubmit">
                @csrf
                <div class="intro-y box lg:mt-5 grid grid-cols-12 gap-6">
                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6 p-5">
                        <div class="pb-5">
                            <label for="name-form-1" class="form-label">{{ __('Issue Name') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" required name="name"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="name" placeholder="Issue Name" aria-label="Issue Name"
                                    aria-describedby="basic-addon2" value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="pt-5 pb-5">
                            <label for="type-form-1" class="form-label">{{ __('Type') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <select name="type" id="type" class="form-control form-control-user">
                                    <option value="">Select Type</option>
                                    <option value="self" @selected(old('type') == 'self')>Self</option>
                                    <option value="both" @selected(old('type') == 'both')>Both</option>
                                </select>
                            </div>
                            @error('type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="pt-5 pb-5">
                            <label for="gender-form-1" class="form-label">{{ __('Gender') }}</label>
                            <div class="input-group">
                                <select name="gender" id="gender" class="form-control form-control-user">
                                    <option value="">Select Gender</option>
                                    <option value="male" @selected(old('gender') == 'male')>Male</option>
                                    <option value="female" @selected(old('gender') == 'female')>Female</option>
                                </select>
                            </div>
                            @error('gender')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6 p-5">
                        <label for="description-form-1" class="form-label">{{ __('Description') }} <span class="text-danger"><sup>*</sup></span></label></label>
                        <div class="col-sm-12">
                            <textarea class="form-control form-control-user @error('description') is-invalid @enderror" name="description" id="description" placeholder="Description" cols="20" rows="10">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary mt-4">Add</button>
                </div>
            </form>
            <!-- END: Add Issue Form -->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let height= '250';
    </script>
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/editor.js') }}"></script>
@endpush
