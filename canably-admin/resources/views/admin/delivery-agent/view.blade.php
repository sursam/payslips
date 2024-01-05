@extends('admin.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/customer.css') }}">
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200">
            <div class="space-y-8 mt-8">
                <div class="form_field">
                    <h2 class="text-xl text-slate-800 font-bold mb-6">General Information</h2>
                    <div class="grid gap-3 md:grid-cols-2 mb-3">

                        <div>
                            <!-- Start -->
                            <div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">First Name :-</span>
                                    <input type="text" disabled class="form-control border-0 " placeholder="Username"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        value="{{ $user->first_name }}">
                                </div>
                            </div>
                            <!-- End -->
                        </div>

                        <div>
                            <!-- Start -->
                            <div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Last Name :-</span>
                                    <input type="text" disabled class="form-control border-0 " placeholder="Username"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        value="{{ $user->last_name }}">
                                </div>
                            </div>
                            <!-- End -->
                        </div>



                    </div>
                    <div class="grid gap-3 md:grid-cols-2">

                        <div>
                            <!-- Start -->
                            <div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Email :-</span>
                                    <input type="text" disabled class="form-control border-0 " placeholder="Username"
                                        aria-label="Username" aria-describedby="basic-addon1" value="{{ $user->email }}">
                                </div>
                            </div>
                            <!-- End -->
                        </div>

                        <div>
                            <!-- Start -->
                            <div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Contact No :-</span>
                                    <input type="text" disabled class="form-control border-0 " placeholder="Username"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        value="{{ $user->mobile_number }}">
                                </div>
                            </div>
                            <!-- End -->
                        </div>

                    </div>
                </div>
            </div>
            <div class="space-y-8 mt-8">
                <div class="form_field">
                    <h2 class="text-xl text-slate-800 font-bold mb-6">Additional Info</h2>

                    <div class="grid gap-3 md:grid-cols-1">
                        <div>
                            <!-- Start -->
                            <div>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">Full Address:-</span>
                                    <textarea class="form-control" disabled aria-label="With textarea">{{ $user->profile?->address }},</textarea>
                                </div>
                            </div>
                            <!-- End -->
                        </div>
                        <div>
                            <!-- Start -->
                            <div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Zip Code :-</span>
                                    <input type="text" disabled class="form-control border-0 " placeholder="Username"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        value="{{ $user->profile?->zipcode }}">
                                </div>
                            </div>
                            <!-- End -->
                        </div>

                    </div>
                    <div class="grid gap-3 md:grid-cols-2">



                        <div> <!-- Start -->

                            <div class="w-75">
                                <label class="block text-sm font-medium mb-1">Profile Picture</label>
                                <img class="ml-1 img-thumbnail" src="{{ $user->customer_picture }}"
                                    alt="Icon 01" />
                            </div>
                            <!-- End -->
                        </div>
                        <div>
                            <div class="w-75">
                                <label class="block text-sm font-medium mb-1">Driving Licence</label>
                                <img class="ml-1 img-thumbnail" src="{{ $user->driving_license }}"
                                    alt="Icon 01" />
                            </div>
                        </div>


                    </div>

                </div>


            </div>
            <div class="space-y-8 mt-8">
                <div class="form_field">
                    <h2 class="text-xl text-slate-800 font-bold mb-6">Bak Info</h2>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <!-- Start -->
                            <div>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">Bank Name</span>
                                    <input type="text" disabled class="form-control border-0 " placeholder="Bank Name"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        value="{{ $user->account?->bank }}">
                                </div>
                            </div>
                            <!-- End -->
                        </div>
                        <div>
                            <!-- Start -->
                            <div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Account holder name</span>
                                    <input type="text" disabled class="form-control border-0 " placeholder="Account holder name"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        value="{{ $user->account?->full_name }}">
                                </div>
                            </div>
                            <!-- End -->
                        </div>

                    </div>
                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <!-- Start -->
                            <div>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">Account Number</span>
                                    <input type="text" disabled class="form-control border-0 " placeholder="Bank Name"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        value="{{ $user->account?->account }}">
                                </div>
                            </div>
                            <!-- End -->
                        </div>
                        <div>
                            <!-- Start -->
                            <div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">Ach</span>
                                    <input type="text" disabled class="form-control border-0 " placeholder="Account holder name"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        value="{{ $user->account?->ach }}">
                                </div>
                            </div>
                            <!-- End -->
                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>
@endsection
@push('scripts')
@endpush
