@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
{{--  @dd($companyData->locations?->first())  --}}
    <div class="intro-y items-center mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-6">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <h2 class="text-lg font-medium mr-auto">
                        <a href="{{ route('admin.users.customer.edit',$userData->uuid) }}" class="nav-link">
                            {{ __('Update Business User') }}
                        </a>
                    </h2>
                </li>
                <li class="nav-item">
                    <h2 class="text-lg font-medium mr-auto">
                        <a href="#" class="nav-link active">
                            {{ __('Company Informations') }}
                        </a>
                    </h2>
                </li>
            </ul>
        </div>
        <div class="col-6 col-span-6 text-right">
            <a href="{{ route('admin.users.customer.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">
        
        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Add User Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.users.customer.company',$userData->uuid) }}" id="usersubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('CIN Number') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" required name="registration_number" class="form-control form-control-user @error('registration_number') is-invalid @enderror" id="registration_number" placeholder="CIN Number" aria-label="CIN Number" aria-describedby="basic-addon2" value="{{ old('registration_number') ?? $companyData->registration_number }}">
                            </div>
                            @error('registration_number')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Name') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" required name="name" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" placeholder="Name" aria-label="Name" aria-describedby="basic-addon2" value="{{ old('name') ?? $companyData->name }}">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Company Name') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" required name="company_name" class="form-control form-control-user @error('company_name') is-invalid @enderror" id="company_name" placeholder="Company Name" aria-label="Company Name" aria-describedby="basic-addon2" value="{{ old('company_name') ?? $companyData->company_name }}">
                            </div>
                            @error('company_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Business Name') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" required name="business_name" class="form-control form-control-user @error('business_name') is-invalid @enderror" id="business_name" placeholder="Business Number" aria-label="Business Number" aria-describedby="basic-addon2" value="{{ old('business_name') ?? $companyData->business_name }}">
                            </div>
                            @error('business_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('State') }} <span class="text-danger"><sup>*</sup></span></label>
                            <select class="form-control select2bs4 getPopulate" name="state_id"
                                data-location="cities" data-message="city" id="state">
                                <option value="">Select State</option>
                                @forelse ($states as $state)
                                    <option value="{{ $state->id }}"
                                        data-populate="{{ json_encode($state->cities->pluck('name', 'id')) }}"
                                        @selected($companyData->locations?->first()?->state_id == $state->id)>
                                        {{ preg_replace('/[^A-Za-z0-9\-]/', '', $state->name) }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('state')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('City') }} <span class="text-danger"><sup>*</sup></span></label>
                            <select class="form-control cities" id="cities" name="city_id" data-auth="{{ $companyData->locations?->first()?->city_id }}">
                                <option>Select City</option>
                            </select>
                            @error('city')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('zipcode') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" required name="zipcode" class="form-control form-control-user @error('zipcode') is-invalid @enderror" id="postcode" placeholder="Postcode" aria-label="Postcode" aria-describedby="basic-addon2" value="{{ old('zipcode') ?? $companyData->locations?->first()?->zipcode }}">
                            </div>
                            @error('zipcode')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Company Trading Address') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" required name="trading_address" class="form-control form-control-user @error('trading_address') is-invalid @enderror" id="trading_address" placeholder="Company Trading Address" aria-label="Company Trading Address" aria-describedby="basic-addon2" value="{{ old('trading_address') ?? $companyData->trading_address }}">
                            </div>
                            @error('trading_address')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Company Registered Address') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" required name="registered_address" class="form-control form-control-user @error('registered_address') is-invalid @enderror" id="registered_address" placeholder="Company Registered Address" aria-label="Company Registered Address" aria-describedby="basic-addon2" value="{{ old('registered_address') ?? $companyData->registered_address }}">
                            </div>
                            @error('registered_address')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Company Website') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" required name="website" class="form-control form-control-user @error('website') is-invalid @enderror" id="website" placeholder="Company Website" aria-label="Company Website" aria-describedby="basic-addon2" value="{{ old('website') ?? $companyData->website }}">
                            </div>
                            @error('website')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Type of Ownership') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <select name="ownership" id="ownership" class="form-control form-control-user">
                                    <option value="">Select Type</option>
                                    <option value="type-one" @selected($companyData->ownership == 'type-one' || old('ownership') == 'type-one')>Type One</option>
                                    <option value="type-two" @selected($companyData->ownership == 'type-two' || old('ownership') == 'type-two')>Type Two</option>
                                </select>
                            </div>
                            @error('ownership')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Start Trade Date') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="date" required name="trade_started_at" class="form-control form-control-user @error('trade_started_at') is-invalid @enderror" id="trade_started_at" placeholder="Start Trade Date" aria-label="Start Trade Date" aria-describedby="basic-addon2" value="{{ old('trade_started_at') ?? $companyData->trade_started_at?->format('Y-m-d') }}">
                            </div>
                            @error('trade_started_at')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Annual Turnover / Estimated Turnover') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" required name="turnover" class="form-control form-control-user @error('turnover') is-invalid @enderror" id="turnover" placeholder="Annual Turnover / Estimated Turnover" aria-label="Annual Turnover / Estimated Turnover" aria-describedby="basic-addon2" value="{{ old('turnover') ?? $companyData->turnover }}">
                            </div>
                            @error('turnover')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('No. of Employees') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" required name="employeees" class="form-control form-control-user @error('employeees') is-invalid @enderror" id="employeees" placeholder="No. of Employees" aria-label="No. of Employees" aria-describedby="basic-addon2" value="{{ old('employeees') ?? $companyData->employeees }}">
                            </div>
                            @error('employeees')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('VAT Registered Company?') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="radio-group">
                                <label>
                                    <input type="radio" class="radio-control is_vat_registered" name="is_vat_registered" value="1" @checked($companyData->vat_no)>
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" class="radio-control is_vat_registered" name="is_vat_registered" value="0" @checked(!$companyData->vat_no)>
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6 vat_number">
                            <label for="name-form-1" class="form-label">{{ __('VAT Number') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <input type="text" name="vat_no" class="form-control form-control-user vat_no @error('vat_no') is-invalid @enderror" id="vat_no" placeholder="VAT Number" aria-label="VAT Number" aria-describedby="basic-addon2" value="{{ $companyData->vat_no }}">
                            </div>
                            @error('vat_no')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                            <label for="name-form-1" class="form-label">{{ __('Services / Products') }}</label>
                            <div class="grid grid-cols-12 gap-6 mb-5">
                                <div class="col-span-11 lg:col-span-11 2xl:col-span-11">
                                    <div class="single-login service-input">
                                        <label class="form-label">Add Your Services</label>
                                        <input class="form-control" type="text" name="" id="serviceInput" placeholder="Add Service Name">
                                    </div>
                                </div>
                                <div class="col-span-1 lg:col-span-1 2xl:col-span-1">
                                    <a href="#" class="plus-btn">
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-6 serevice-list">
                                @forelse ($companyData->services as $key => $companyService)
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6 service-item">
                                        <p class="box-delete"><span><i class="fa-solid fa-circle"></i> {{ $companyService->name }} </span><a href="#" class="delete-btn"><i class="fa-solid fa-trash-can"></i></a><input type="hidden" name="services[]" value="{{ $companyService->name }}">
                                        </p>
                                    </div>
                                    @empty
                                        <p>No services / products</p>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" name="role" value="customer">
                <button type="submit" class="btn btn-primary mt-4">Save</button>
            </form>
            <!-- END: Add User Form -->
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/editor.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-tagsinput.js') }}"></script>
    <script>
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword']) ? $seo['meta_keyword'] : ''; ?>";
        $('#meta_keyword').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#meta_keyword').tagsinput('add', meta_keyword_values);

        $(document).ready(function () {
            $(document).on("click", ".plus-btn", function (e) {
                e.preventDefault();
                if($("#serviceInput").val()){
                    var serviceRow = '<div class="col-span-6 lg:col-span-6 2xl:col-span-6 service-item"><p class="box-delete"><span><i class="fa-solid fa-circle"></i> '+$("#serviceInput").val()+' </span><a href="#" class="delete-btn"><i class="fa-solid fa-trash-can"></i></a><input type="hidden" name="services[]" value="'+$("#serviceInput").val()+'"></p></div>';
                    $(".serevice-list").append(serviceRow);
                    $("#serviceInput").val('');
                }else{
                    alert('Service name is required');
                }
            });
            $(document).on("click", ".delete-btn", function (e) {
                e.preventDefault();
                $(this).closest('.service-item').remove();
            });
        });
    </script>
@endpush
