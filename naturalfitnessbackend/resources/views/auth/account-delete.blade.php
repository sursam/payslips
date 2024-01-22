@extends('layouts.app', ['isNavbar' => true, 'isFooter' => false, 'customClass' => 'body-wrapper'])
@push('styles')
@section('content')
<div class="block xl:grid grid-cols-2 gap-4">
    <!-- BEGIN: Login Info -->
    <div class="hidden xl:flex flex-col min-h-screen">
        <a href="" class="-intro-x flex items-center pt-5">
            <img alt="Midone - HTML Admin Template" class="h-12" src="{{ asset('assets/images/full-logo.png') }}">
        </a>
        <div class="my-auto">
            <img alt="Midone - HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="{{ asset('assets/images/illustration.svg') }}">
            <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                A few more clicks to
                <br>
            delete your account.
            </div>
            <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your accounts in one place.</div>
        </div>
    </div>
    <!-- END: Login Info -->
    <!-- BEGIN: Login Form -->
    <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                {{ __('Delete Account') }}
            </h2>
            <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">Enter your phone number to send account delete request.</div>
            <form method="POST">
                @csrf
                <div class="intro-x mt-8">
                    <input class="intro-x login__input form-control py-3 px-4 block @error('mobile_number') is-invalid @enderror" placeholder="Mobile Number" id="mobile_number" type="number" name="mobile_number"  required autocomplete="mobile_number" autofocus>
                    @error('mobile_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                    <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                        {{ __('Submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- END: Login Form -->
</div>
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