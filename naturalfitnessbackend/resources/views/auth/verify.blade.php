@extends('layouts.frontend', ['isNavbar' => true, 'isFooter' => false, 'customClass' => 'body-wrapper'])
@section('content')
    <section class="login-sec">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="login-secright">
                        <div class="login-rightbox">
                            <div class="login-form">
                                <h3>{{ __('Welcome User') }}</h3>
                                <label class="mt-2">{{ __('Verify Your Email Address') }}</label>
                                @if (session('resent'))
                                    <div class="alert alert-success" role="alert">
                                        {{ __('A fresh verification link has been sent to your email address.') }}
                                    </div>
                                @endif

                                {{ __('Before proceeding, please check your email for a verification link.') }}
                                {{ __('If you did not receive the email') }},
                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('click here to request another') }}</button>.
                                </form>
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
