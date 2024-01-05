@extends('customer.layouts.app', ['navbar' => true, 'sidebar' => true, 'footer' => false])
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.css"/>
@endpush
@section('content')
    <div id="Profile" class="w3-container city">
        <div class="profile-row">
            <h2>My Profile</h2>
            <div class="profile-row-img">
                <img src="{{ auth()->user()->customer_picture }}" alt="{{ auth()->user()->full_name }}" class=" img-fluid avatar">
                <label class="progile-edit-btn">
                <input type="file" class=" file-upload pro-file-upload" id="validatedCustomFile" name="profile_picture">
                <i class="fa fa-camera" aria-hidden="true"></i>
                </label>
            </div>
            <form method="POST"  action="{{ route('customer.update.profile') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="customerFirstName">First Name</label>
                        <input type="text" name="first_name" class="form-control" id="customerFirstName"
                            placeholder="First Name" autofocus value="{{ auth()->user()->first_name }}">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="customerLastName">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="customerLastName" value="{{ auth()->user()->last_name }}"
                            placeholder="Last Name">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="customerEmail">Email Address</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" id="customerEmail" placeholder="Email Address" readonly>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="customerMobileNumber">Phone</label>
                        <input type="number" name="mobile_number" class="form-control" id="customerMobileNumber" placeholder="Phone" value="{{ auth()->user()->mobile_number  }}">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="customerGender">Gender</label>
                        <select name="gender" id="customerGender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="male" @if ( auth()->user()->profile->gender=="male") selected @endif>Male</option>
                            <option value="female" @if ( auth()->user()->profile->gender=="female") selected @endif>Female</option>
                            <option value="other" @if ( auth()->user()->profile->gender=="other") selected @endif>Other</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="customerBirthDay">Birthday</label>
                        <input type="date" name="birthday" class="form-control" id="customerBirthDay" value="{{ auth()->user()->profile->birthday }}" placeholder="Birth Day">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="customerCountry">Country</label>
                        <input type="text" name="country" value="{{ auth()->user()->profile->country }}" class="form-control" id="customerCountry" placeholder="Country">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="customerState">State</label>
                        <input type="text" name="state" value="{{ auth()->user()->profile->state }}" class="form-control" id="customerState" placeholder="State">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="customerCity">City</label>
                        <input type="text" name="city" value="{{ auth()->user()->profile->city }}" class="form-control" id="customerCity" placeholder="City" >
                    </div>

                </div>
                <div class="form-group col-lg-12">
                    <input type="submit" class="shop-shop-now default-button" value="Update Profile">
                </div>
            </form>

        </div>
    </div>
    @include('modals.crop-modal')
@endsection
@push('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/frontend/js/crop.js') }}" defer></script>
@endpush
