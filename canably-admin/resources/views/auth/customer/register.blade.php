@extends('auth.customer.partials.app')

@push('styles')

@endpush

@section('content')
    <div class="login-logo"><a href="{{ url('/') }}"><img src="{{ asset('assets/frontend/images/logo.png') }}" alt=""></a>
    </div>
    <div class="login-bg-inner">
        <h2>Sign Up</h2>
        <form method="post" action="{{ route('signup') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" required aria-describedby="emailHelp" placeholder="Email address" name="email" autocomplete="off" value="{{ old('email') }}">
                @error('email')
                    <div class="text-xs mt-1 text-rose-500">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="justify-content-center">A password will be sent to your email address.</div>
            <div class="form-group">
                <div class="justify-content-center">Your personal data will be used to support your experience throughout
                    this website, to manage access to your account, and for other purposes described in our
                    <a href="https://www.canably.co/privacy-policy/" class="" target="_blank">privacy policy</a>.
                </div>
            </div>
            <div class="form-group">
                <div class="d-flex">
                    <a class="col text-left" href="javascript:void(0)">Signup as a vendor?</a>
                    <a class="col text-right" href="{{ route('login') }}">Already Have an Account? Login</a>
                </div>
            </div>

            <div class="form-group form-check">
                <div class="row">
                    <div class="col-lg-7">
                        <input type="checkbox" class="form-check-input @error('privacypolicy') is-invalid @enderror" name="privacypolicy" id="exampleCheck1">
                        <label class="form-check-label remember-me" for="exampleCheck1">
                            I Accept <a href="https://www.canably.co/privacy-policy/" target="_blank">Privacy Policy</a>
                        </label>
                        @error('privacypolicy')
                            <div class="text-xs mt-1 text-rose-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="submit-row">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
