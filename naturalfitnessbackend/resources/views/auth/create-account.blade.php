@extends('layouts.frontend', ['isNavbar' => true, 'isFooter' => false, 'customClass' => 'body-wrapper'])
@push('styles')
@section('content')
    <section class="get-start-sec">
        <div class="registration_form">

            <div class="frm-center">
                    <h3>{{ __('Create Account') }}</h3>
                    <h6>{{ __('For creating a new account please fill the details') }}</h6>

                    <form method="POST" action="{{ route('frontend.create.account') }}">
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
                        {{--  @if(!$uuid)
                            <div class="single-login">
                                <label class="login-label">Role <span class="text-danger"><sup>*</sup></span></label>
                                <select class="form-control select2bs4" name="role" id="role">
                                    <option value="">Select Role</option>
                                    <option value="customer">Business User</option>
                                    <option value="agent">Agent</option>
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="role" value="customer">
                        @endif  --}}
                        <input type="hidden" name="role" value="customer">
                        
                        {{--  <input type="hidden" name="is_approve" value="0">  --}}
                        <input type="hidden" name="enquiryUuid" value="{{ $uuid }}">
                        <button type="submit" class="mx-auto btn btn-primary btn-effect btn-effect-arrow mt-4">
                            {{ (!$uuid) ? __('SUBMIT') : __('NEXT') }}
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