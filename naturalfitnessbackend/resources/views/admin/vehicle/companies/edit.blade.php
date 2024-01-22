@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Edit Vehicle Company') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.vehicle.company.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">
        
        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Edit Vehicle Company Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.vehicle.company.edit',$vehicleCompanyData->uuid) }}" id="vehiclesubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                            <label for="name-form-1" class="form-label">{{ __('Company') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="text" required name="name" class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="name" placeholder="Company Name" aria-label="Company Name" aria-describedby="basic-addon2" value="{{ $vehicleCompanyData->name }}">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary mt-4">Save</button>
            </form>
            <!-- END: Edit Vehicle Company Form -->
        </div>
    </div>

@endsection

@push('scripts')
@endpush