@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    {{-- @include('errors.all') --}}
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Add Membership') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.settings.membership.list') }}" class="btn btn-warning btn-icon-split">
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
                action="{{ route('admin.settings.membership.add') }}" id="pagesubmit">
                @csrf

                <div class="intro-y box lg:mt-5">

                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                            <label for="name-form-1" class="form-label">{{ __('Name') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="text" required name="name" value="{{ old('name') }}"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="name" placeholder="Name" aria-label=" Name" aria-describedby="basic-addon2">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Duration(Days)') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="number" required name="duration" value="{{ old('duration') }}"
                                    class="form-control form-control-user @error('duration') is-invalid @enderror"
                                    id="duration" placeholder="Duration" aria-label=" Duration" aria-describedby="basic-addon2">
                            </div>
                            @error('duration')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Amount($)') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="number" required name="price" value="{{ old('price') }}"
                                    class="form-control form-control-user @error('amount') is-invalid @enderror" id="price" placeholder="Amount" aria-label="Amount" aria-describedby="basic-addon2">
                            </div>
                            @error('price')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary mt-4">Add</button>
                </div>
            </form>
            <!-- END: Add Page Form -->
        </div>
    </div>
@endsection
