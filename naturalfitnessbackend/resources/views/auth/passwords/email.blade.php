@extends('layouts.frontend', ['isNavbar' => false, 'isFooter' => false])
@section('content')
    <section class="login-sec">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="login-secright">
                        <div class="login-rightbox">
                            <div class="login-rheadlogo">
                                <a href="{{ route('frontend.home') }}">
                                    <img src="{{ asset('assets/frontend/customer/images/logo.svg') }}" class="img-fluid" alt="">
                                </a>
                            </div>
                            <div class="login-form">
                                <h3>{{ __('Forgot Password?') }}</h3>
                                <label class="mt-2">{{ __('Please enter your registered email ID for change your password.') }}</label>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <input type="hidden" name="recaptcha" id="recaptcha">
                                    <div class="single-login">
                                        <div>
                                            <label class="login-label"> {{ __('Email ID') }} <span class="text-danger"><sup>*</sup></span></label>
                                            <input class="form-control" type="text" name="email" id="email"
                                                placeholder="Enter your registered email ID" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-effect btn-effect-arrow mt-4">
                                        Submit
                                    </button>
                                </form>
                                <p>{{ __("Already have an account?") }} <a href="{{ route('login') }}">Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="login-secleft">
                        <div class="login-leftup">
                            <img src="{{ asset('assets/frontend/customer/images/log-in.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
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
                    action: 'forget'
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