@extends('customer.layouts.app', ['header' => false, 'sidebar' => false,'navbar'=>false,'footer' => false,'noContent'=>true])
@section('verify')


            <div class="container">
                <div class="row custom-align-center">
                    <div class="e-verify-message inner-content-area">
                        <div class="verify-icon">
                            <img src="{{ asset('assets/images/success.png') }}" alt="">
                        </div>
                        <h2>Successfully Verified</h2>
                        <p>Your email has now been verified!</p>
                        <a onclick="location.href='{{ route('frontend.home') }}'">CONTINUE</a>
                    </div>
                </div>
            </div>
        </article>
@endsection

@push('scripts')
<script  src="{{ asset('assets/frontend/js/auth/auth.js') }}" defer></script>
@endpush
