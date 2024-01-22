@extends('layouts.app')

@section('content')
<div class="block xl:grid grid-cols-2 gap-4">
    <!-- BEGIN: Login Info -->
    <div class="hidden xl:flex flex-col min-h-screen">
        <a href="" class="-intro-x flex items-center pt-5">
            <img alt="Natural Fitness" class="h-20" src="{{ asset('assets/images/full-logo.png') }}">
        </a>
        <div class="my-auto">
            <img alt="Natural Fitness" class="-intro-x w-1/2 -mt-16" src="{{ asset('assets/images/illustration.svg') }}">
            <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                A few more clicks to
                <br>
                sign in to your account.
            </div>
            <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your accounts in one place</div>
        </div>
    </div>
    <!-- END: Login Info -->
    <!-- BEGIN: Login Form -->
    <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                {{ __('Forgot Password?') }}
            </h2>
            <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your accounts in one place</div>
            <form method="POST" action="{{ route('forgot-password.post') }}">
                @csrf
                <input type="hidden" name="recaptcha" id="recaptcha" value="">
                <p class="text-muted mb-4 text-center font-weight-light">
                    @lang('Please provide your email below and we will send you a password reset link.')
                </p>
                <div class="intro-x mt-8">
                    <input id="email" type="email" class="intro-x login__input form-control py-3 px-4 block @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @error('recaptcha')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                    <div class="flex items-center mr-auto">
                    </div>
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}">
                            {{ __('Back to login?') }}
                        </a>
                    @endif
                </div>
                <div class="intro-x text-center xl:text-left">
                    <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                        {{ __('Send') }}
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
