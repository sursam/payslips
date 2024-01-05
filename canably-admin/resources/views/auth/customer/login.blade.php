@extends('auth.customer.partials.app')

@push('styles')
@endpush

@section('content')
    <div class="login-logo"><a href="{{ url('/') }}"><img src="{{ asset('assets/frontend/images/logo.png') }}" alt=""></a>
    </div>
    <div class="login-bg-inner">
        <h2>Sign In</h2>
        <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="text" class="form-control" id="email" aria-describedby="emailHelp"
                    placeholder="Email address" name="email">
                @error('email')
                    <div class="text-xs mt-1 text-rose-500">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                @error('password')
                    <div class="text-xs mt-1 text-rose-500">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group form-check">
                <div class="row">
                    <div class="col-lg-7">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label remember-me" for="exampleCheck1">Remember Me</label>
                    </div>
                    <div class="col-lg-5">
                        <label class="form-check-label forgot-password" for="exampleCheck1"><a href="#">Forgot
                                Password?</a></label>
                    </div>
                </div>
            </div>
            <div class="submit-row">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <div class="new-to">
        <h2>New to Canably</h2>
        <div class="account-now"> <a class="btn btn-primary" href="{{ route('signup') }}" role="button">Create an
                Account Now</a>
        </div>
    </div>
@endsection

@section('scripts')
