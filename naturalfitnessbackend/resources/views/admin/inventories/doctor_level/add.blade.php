@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')

@endpush

@section('content')
    <div class="container-fluid">

        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{ __("Add Doctor's Level") }}
            </h2>
            <div class="col-6 text-right">
                <a href="{{ route('admin.medical.doctor.level.list') }}" class="btn btn-warning btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.medical.doctor.level.add') }}" id="categorysubmit">
                    @csrf
                    <div class="intro-y box lg:mt-5 grid grid-cols-12 gap-6">
                        <div class="col-span-12 lg:col-span-12 2xl:col-span-12 p-5">
                            <div class="adddia_single">
                                <div class="forminput_box">
                                    <label for="name-form-1" class="form-label">{{ __('Name') }} <span class="text-danger"><sup>*</sup></span></label></label>
                                    <input type="text" required name="name" class="form-control form-control-user @error('name') is-invalid @enderror"
                                        id="name" placeholder="Name" aria-label="Name" aria-describedby="basic-addon2">
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form_btn text-right">
                        <input type="hidden" name="type" value="doctor_level">
                        <button type="submit" class="btn btn-primary mt-4">Add</button>
                    </div>
                </form>
            </div>
            <!-- END: Data List -->

        </div>

    </div>

@endsection

@push('scripts')
@endpush


