@extends('frontend.layouts.app', ['navbar' => true, 'footer' => true])
@push('styles')
@endpush
@section('content')
    <section class="faq_sec">
        <div class="faq_sechead">
            <h3>Contact Us</h3>
        </div>
        <div class="contact-sec">
            <div class="container">
                <h3 class="con_head">
                    Contact Information
                </h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="contactd-box">
                            <i class="fa-regular fa-envelope"></i>
                            <h6 class="cbox-title">
                                E-mail Address
                            </h6>
                            <p class="cbox-info">
                                <a href="mailto:info@canably.com">info@canably.com</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contactd-box">
                            <i class="fa-solid fa-headphones-simple"></i>
                            <h6 class="cbox-title">
                                Phone Number
                            </h6>
                            <p class="cbox-info">
                                <a href="tel:8004301415">(800) 430-1415</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contactd-box">
                            <i class="fa-solid fa-location-dot"></i>
                            <h6 class="cbox-title">
                                Address
                            </h6>
                            <p class="cbox-info">
                                2971 India St, San Diego, CA 92103
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col-md-6">
                        <div class="conform-img">
                            <img src="{{ asset('assets/frontend/images/conimg.jpg') }}" class="img-fluid" alt="contact-img">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="conform-form">
                            <h3>GET IN CONTACT</h3>
                            <p>Please fill this form if you have any questions</p>
                            <form action="{{ route('frontend.pages.contact.us.save') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Your name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Your name">
                                    @error('name')
                                        <span class="text-danger d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter email">
                                    @error('email')
                                        <span class="text-danger d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" name="subject" placeholder="Enter Subject">
                                    @error('subject')
                                        <span class="text-danger d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="message">Your Comments (optional)</label>
                                    <textarea class="form-control" name="comment" id="" cols="30" rows="5"></textarea>
                                    @error('comment')
                                        <span class="text-danger d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="add-to-cart default-button submit_form">
                                    <span>Submit</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
