@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="container-fluid">

        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{ __('Add Referral') }}
            </h2>
            <div class="col-6 text-right">
                <a href="{{ route('admin.referral.user.list') }}" class="btn btn-warning btn-icon-split">
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
                <form class="user formSubmit fileUpload referral_form" enctype="multipart/form-data" method="post" action="{{ route('admin.referral.user.add') }}" id="referralsubmit">
                    @csrf
                    <div class="intro-y box lg:mt-5">
                        <div class="p-5 grid grid-cols-12 gap-6">
                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                <label for="name-form-1" class="form-label">{{ __('Reference Source') }} <span class="text-danger"><sup>*</sup></span></label></label>
                                <div class="input-group">
                                    <select required class="form-control select2bs4 getPopulate reference_source" name="category_id" data-message="Reference Source" id="category_id">
                                        @forelse ($referenceSources as $referenceSource)
                                            <option value="{{ $referenceSource->id }}" @selected(old('category_id')==$referenceSource->id)>{{ $referenceSource->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                @error('category_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                <label for="name-form-1" class="form-label">{{ __('Referred User') }} <span class="text-danger"><sup>*</sup></span></label></label>
                                <div class="input-group">
                                    <select required class="form-control select2bs4 getPopulate" name="user_id" data-message="Referred User" id="user_id">
                                        <option value="">Select User</option>
                                        @forelse ($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('user_id')==$user->id)>{{ $user->full_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                @error('user_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6 show_for_dsr">
                                <label for="name-form-1" class="form-label">{{ __('Reference Type') }} <span class="text-danger"><sup>*</sup></span></label></label>
                                <div class="input-group">
                                    <select required class="form-control select2bs4 getPopulate reference_type" name="type" data-message="Reference Type" id="reference_type">
                                        <option value="">Select Type</option>
                                        <option value="self" @selected(old('type')=='self')>Self</option>
                                        <option value="other" @selected(old('type')=='other')>Other</option>
                                    </select>
                                </div>
                                @error('type')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6 show_for_other show_for_dsr">
                                <label for="name-form-1" class="form-label">{{ __('Referred By') }} <span class="text-danger"><sup>*</sup></span></label></label>
                                <div class="input-group">
                                    <input type="text" required name="name" class="form-control form-control-user @error('name') is-invalid @enderror"
                                        id="name" placeholder="Referred By" aria-label="Referred By" aria-describedby="basic-addon2" value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6 show_for_other show_for_dsr">
                                <label for="name-form-1" class="form-label">{{ __('Mobile Number') }} <span class="text-danger"><sup>*</sup></span></label></label>
                                <div class="input-group">
                                    <input type="text" required name="mobile_number" class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                                        id="name" placeholder="Mobile Number" aria-label="Mobile Number" aria-describedby="basic-addon2" value="{{ old('mobile_number') }}">
                                </div>
                                @error('mobile_number')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6 show_for_dsr">
                                <label for="name-form-1" class="form-label">{{ __('DSR IBD Number') }} <span class="text-danger"><sup>*</sup></span></label></label>
                                <div class="input-group">
                                    <input type="text" required name="ibd_number" class="form-control form-control-user @error('ibd_number') is-invalid @enderror"
                                        id="name" placeholder="DSR IBD Number" aria-label="DSR IBD Number" aria-describedby="basic-addon2" value="{{ old('ibd_number') }}">
                                </div>
                                @error('ibd_number')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form_btn text-right">
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


