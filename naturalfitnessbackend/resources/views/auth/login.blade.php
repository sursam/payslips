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
                                <h3>{{ __('Welcome User') }}</h3>
                                <label class="mt-2">{{ __('Please enter your login details') }}</label>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="single-login">
                                        <div>
                                            <label class="login-label"> {{ __('Email ID') }} <span class="text-danger"><sup>*</sup></span></label>
                                            <input class="form-control" type="text" name="email" id="email"
                                                placeholder="Enter your Email ID" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="single-login">
                                        <div class="show_hide_password">
                                            <label class="login-label"> {{ __('Password') }} <span class="text-danger"><sup>*</sup></span></label>
                                            <input id="password-eye" type="password" placeholder="Enter your password"
                                            class="form-control" name="password" required autocomplete="password">
                                            <a href="javascript:void(0)" class="text-decoration-none eye-icon toggle-eye">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                            {{--  <span toggle="#password-eye" class="fa fa-fw fa-eye eye-icon toggle-eye"></span>  --}}
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="flex items-center mr-auto">
                                        <input class="form-check-input border mr-2" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="cursor-pointer select-none" for="remember">{{ __('Remember Me') }}</label>
                                    </div>
                                    <div class="signup-checkbox">
                                        <div class="forgot-btn">
                                            <a href="{{ route('password.request') }}" class="forgot-pass"> Forgot Password?</a>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-effect btn-effect-arrow mt-4">
                                        Login
                                    </button>
                                </form>
                                <p>{{ __("Don't have an account?") }} <a href="{{ route('frontend.create.account') }}">Create Account</a></p>
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
