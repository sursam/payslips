@extends('layouts.frontend', ['isNavbar' => false, 'isFooter' => false])
@section('content')
    <header>
        <div class="container-fluid">
            <div class="row">
                    <div class="custom-hdr">
                        <div class="logo-img">
                            <a href="{{ route('frontend.home') }}">
                                <img src="{{ asset('assets/frontend/customer/images/logo.svg') }}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="log-in-button">
                            <a href="{{ route('login') }}">login</a>
                        </div>
                    </div>
            </div>
        </div>
    </header>
    <section class="get-start-sec">
        <div class="registration_form">

            <div class="frm-center">
                    <h3>{{ __('Create Account') }}</h3>
                    <h6>{{ __('For creating a new account please fill the details') }}</h6>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="recaptcha" id="recaptcha">
                        <div class="single-login">
                            <label class="login-label">Your First Name <span class="text-danger"><sup>*</sup></span></label>
                            <input class="form-control" type="text" name="first_name" id="first_name" placeholder="Enter your First Name" value="{{ $first_name ?? old('first_name') }}" required>
                        </div>
                        <div class="single-login">
                            <label class="login-label">Your Last Name <span class="text-danger"><sup>*</sup></span></label>
                            <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Enter your Last Name" value="{{ $last_name ?? old('last_name') }}" required>
                        </div>
                        <div class="single-login">
                            <label class="login-label">Your Email ID <span class="text-danger"><sup>*</sup></span></label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="Enter your Email ID" value="{{ $email ?? old('email') }}" required>
                        </div>
                        <div class="single-login">
                            <label class="login-label">Mobile Number <span class="text-danger"><sup>*</sup></span></label>
                            <input class="form-control" type="text" name="mobile_number" id="mobile_number" placeholder="Enter your Mobile Number" value="{{ $mobile_number ?? old('mobile_number') }}" required>
                        </div>
                        <input type="hidden" name="role" value="customer">
                        <button type="submit" class="mx-auto btn btn-primary btn-effect btn-effect-arrow mt-4">
                            NEXT
                        </button>
                    </form>
            </div>

        </div>

    </section>
@endsection
@push('scripts')
    <script defer>
        $(document).ready(function() {
            setRecaptchaToken();
            // Every 90 Seconds
            setInterval(function() {
                setRecaptchaToken();
            }, 90 * 1000);
        });

        function setRecaptchaToken() {
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('captcha.sitekey') }}', {
                    action: 'register'
                }).then(function(token) {
                    if (token) {
                        document.getElementById('recaptcha').value = token;
                        $('button[type="submit"]').prop('disabled', false);
                    }
                });
            });
        }
    </script>
@endpush