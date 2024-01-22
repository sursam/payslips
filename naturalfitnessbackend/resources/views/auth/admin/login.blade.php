@extends('layouts.app')

@section('content')
<div class="block xl:grid grid-cols-2 gap-4">
    <!-- BEGIN: Login Info -->
    <div class="hidden xl:flex flex-col min-h-screen">
        <a href="" class="-intro-x flex items-center pt-5">
            <img alt="Natural Fitness" class="h-20" src="{{ asset('assets/images/full-logo.png') }}">
            {{-- <span class="text-white text-lg ml-3"> {{ __("Da'Ride") }} </span> --}}
        </a>
        <div class="my-auto">
            <img alt="Natural Fitness" class="-intro-x w-1/2 -mt-16" src="{{ asset('assets/images/illustration.svg') }}">
            <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                A few more clicks to
                <br>
                sign in to your account.
            </div>
            <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your accounts in one place.</div>
        </div>
    </div>
    <!-- END: Login Info -->
    <!-- BEGIN: Login Form -->
    <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                {{ __('Sign In') }}
            </h2>
            <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your accounts in one place.</div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="intro-x mt-8">
                    <input class="intro-x login__input form-control py-3 px-4 block @error('email') is-invalid @enderror" placeholder="Email" id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4 @error('password') is-invalid @enderror" placeholder="Password" id="password" type="password" name="password" required autocomplete="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                    <div class="flex items-center mr-auto">
                        <input class="form-check-input border mr-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="cursor-pointer select-none" for="remember">{{ __('Remember Me') }}</label>
                    </div>
                    @if (Route::has('forgot-password'))
                        <a href="{{ route('forgot-password') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                    <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- END: Login Form -->
</div>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
