@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/custom/css/style.css') }}">
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Add Booking') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.booking.list') }}" class="btn btn-warning btn-icon-split">
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
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.booking.add') }}" id="usersubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Issues') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <select class="form-control select2 @error('issue_id') is-invalid @enderror" name="issue_id"
                                data-location="issues" data-message="issue" id="issue_id">
                                    <option value="">Select Issue</option>
                                    @forelse ($issues as $issue)
                                        <option value="{{ $issue->id }}" @selected(old('issue_id') == $issue->id)>
                                            {{ $issue->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            @error('issue_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Doctor') }} </label></label>
                            <div class="input-group">
                                <select class="form-control select2 @error('doctor_id') is-invalid @enderror" name="doctor_id"
                                data-location="doctors" data-message="doctor" id="doctor_id">
                                    <option value="">Select Doctor</option>
                                    @forelse ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>
                                            {{ $doctor->full_name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            @error('doctor_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Patient') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <select class="form-control select2 @error('patient_id') is-invalid @enderror" name="patient_id"
                                data-location="patients" data-message="patient" id="patient_id">
                                    <option value="">Select Patient</option>
                                    @forelse ($patients as $patient)
                                        <option value="{{ $patient->id }}" @selected(old('patient_id') == $patient->id)>
                                            {{ $patient->full_name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            @error('patient_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="intro-y box lg:mt-5">
                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Booking For') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <select class="form-control select2 @error('booking_for') is-invalid @enderror" name="booking_for" data-message="Booking For" id="booking_for">
                                    <option value="">Select</option>
                                    <option value="self" @selected(old('booking_for') == 'self')>Self</option>
                                    <option value="other" @selected(old('booking_for') == 'other')>Other</option>
                                </select>
                            </div>
                            @error('booking_for')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6"></div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6 booking_for_other">
                            <label for="name-form-1" class="form-label">{{ __('Name') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" name="other_name" class="form-control form-control-user @error('other_name') is-invalid @enderror" id="other_name" placeholder="Name" aria-label="Name" aria-describedby="basic-addon2" value="{{ old('other_name') }}">
                            </div>
                            @error('other_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6 booking_for_other">
                            <label for="name-form-1" class="form-label">{{ __('Age') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="number" name="other_age" class="form-control form-control-user @error('other_age') is-invalid @enderror" id="other_age" placeholder="Age" aria-label="Age" aria-describedby="basic-addon2" value="{{ old('other_age') }}">
                            </div>
                            @error('other_age')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6 booking_for_other">
                            <label for="name-form-1" class="form-label">{{ __('Relationship With Patient') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" name="other_relationship" class="form-control form-control-user @error('other_relationship') is-invalid @enderror" id="other_relationship" placeholder="Ex. Mother, Father" aria-label="Relationship With Patient" aria-describedby="basic-addon2" value="{{ old('other_relationship') }}">
                            </div>
                            @error('other_relationship')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6 booking_for_other">
                            <label for="name-form-1" class="form-label">{{ __('Gender') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <select class="form-control select2 @error('gender') is-invalid @enderror" name="other_gender" data-message="gender" id="other_gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" @selected(old('other_gender') == 'male')>Male</option>
                                    <option value="female" @selected(old('other_gender') == 'female')>Female</option>
                                    <option value="other" @selected(old('other_gender') == 'other')>Other</option>
                                </select>
                            </div>
                            @error('other_gender')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Type of Consultation') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <select class="form-control select2 @error('consultaion_type') is-invalid @enderror" name="consultaion_type" data-message="Type of Consultation" id="consultaion_type">
                                    <option value="">Select</option>
                                    <option value="online" @selected(old('consultaion_type') == 'online')>Online</option>
                                    <option value="offline" @selected(old('consultaion_type') == 'offline')>Offline</option>
                                </select>
                            </div>
                            @error('consultaion_type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                            <label for="name-form-1" class="form-label">{{ __('Select who you want?') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <select class="form-control select2 @error('doctor_level_id') is-invalid @enderror" name="doctor_level_id" data-message="Who you want" id="doctor_level_id">
                                    <option value="">Select</option>
                                    @forelse ($doctorLevels as $doctorLevel)
                                        <option value="{{ $doctorLevel->id }}" @selected(old('doctor_level_id') == $doctorLevel->id)>
                                            {{ $doctorLevel->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            @error('doctor_level_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                            <label for="name-form-1" class="form-label">{{ __('Do you want to convey anything to the doctor?') }} </label></label>
                            <div class="input-group">
                                <textarea name="other_info" class="form-control form-control-user @error('other_info') is-invalid @enderror" id="other_info" placeholder="Other info" aria-label="Other info" aria-describedby="basic-addon2">{{ old('other_info') }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="intro-y box lg:mt-5">
                    <div class="p-5 grid grid-cols-7 gap-6 date_row">
                        @for($i = 1; $i <= 7; $i++)
                            <div class="date_box">
                                <input type="radio" id="date{{ $i }}" name="booking_date" value="{{ \Carbon\Carbon::today()->addDays($i)->format('Y-m-d') }}" class="booking_date" data-bookedtime="">
                                <label for="date{{ $i }}">
                                    {{ \Carbon\Carbon::today()->addDays($i)->format('D') }}
                                    <h6>
                                        {{ \Carbon\Carbon::today()->addDays($i)->format('d') }}
                                    </h6>
                                    {{ \Carbon\Carbon::today()->addDays($i)->format('M') }}
                                </label>
                            </div>
                        @endfor
                    </div>
                    @error('booking_date')
                        <span class="invalid-feedback d-block p-5" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="time_row">
                        <div class="p-5 grid grid-cols-8 gap-6 times_container"></div>
                        <div class="loader">
                            <div class="loading">
                            </div>
                        </div>
                        @error('booking_datetime')
                            <span class="invalid-feedback d-block p-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary mt-4">Add</button>
                </div>
            </form>
            <!-- END: Add User Form -->
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/custom/js/admin.js') }}"></script>
@endpush
