<!-- footer start -->
<footer>
    <div class="footer-custom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer-main row">
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-box">
                                <div class="footer-title mobile-title">
                                    <h5>about</h5>
                                </div>
                                <div class="footer-contant">
                                    <div class="footer-logo">
                                        <a href="{{ url('/') }}">
                                            <img src="{{ asset('assets/frontend/images/logo.png') }}" class="img-fluid"
                                                alt="logo">
                                        </a>
                                    </div>
                                    <p>Canably is a new and innovative company in the CBD industry. Canably provides a
                                        large range of CBD products and brands,</p>
                                    <ul class="sosiyal">
                                        <li>
                                            <a target="_blank"
                                                href="{{ getSiteSetting('facebook_url') ?? 'https://www.facebook.com/Canably' }}">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank" href="{{ getSiteSetting('twitter_url') ?? '#' }}">
                                                <i class="fa-brands fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank" href="{{ getSiteSetting('instagram_url') ?? '#' }}">
                                                <i class="fa-brands fa-instagram"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank" href="{{ getSiteSetting('linkedln_url') ?? '#' }}">
                                                <i class="fa-brands fa-linkedin"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank" href="{{ getSiteSetting('google_url') ?? '#' }}">
                                                <i class="fa-brands fa-google"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank" href="{{ getSiteSetting('yelp_url') ?? '#' }}">
                                                <i class="fa-brands fa-yelp"></i>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-box">
                                <div class="footer-title">
                                    <h5>QUICK LINKS</h5>
                                </div>
                                <div class="footer-contant">
                                    <ul class="footer-list">
                                        @forelse ($pages as $page)
                                            @if ($page->position == 'division-1')
                                                <li><a href="{{ $page->link }}"> {{ $page->title ?? $page->name }}
                                                    </a></li>
                                            @endif

                                        @empty
                                        @endforelse
                                        <li><a href="{{ route('frontend.pages.any.pages', 'about-us') }}"> About Us
                                            </a></li>
                                        <li><a href="{{ route('frontend.pages.contact.us') }}"> Contact Us </a></li>
                                        <li><a href="{{ route('frontend.shop.by.type', 'all') }}"> Shop </a></li>
                                        <li><a href="{{ route('frontend.pages.any.pages', 'blogs') }}"> News </a></li>
                                        <li>
                                            <a href="{{ route('customer.dashboard') }}"> My account </a>
                                        </li>
                                        <li> <a href="{{ route('customer.order.list') }}"> Track My Order </a></li>
                                        <li> <a href="{{ route('frontend.cart') }}">Cart </a></li>
                                    </ul>
                                    <ul class="footer-list">
                                        @forelse ($pages as $page)
                                            @if ($page->position == 'division-2')
                                                <li><a href="{{ $page->link }}"> {{ $page->title ?? $page->name }}
                                                    </a></li>
                                            @endif
                                        @empty
                                        @endforelse

                                        <li> <a href="{{ route('frontend.become.driver') }}">Become A Driver </a></li>
                                        <li> <a href="{{ route('customer.order.list') }}">Orders</a></li>
                                        <li> <a href="{{ route('frontend.pages.any.pages', 'faqs') }}">FAQs </a></li>
                                        <li> <a href="{{ route('frontend.pages.any.pages', 'disclaimer') }}">Disclaimer
                                            </a></li>
                                        <li> <a href="{{ route('frontend.pages.any.pages', 'privacy-policy') }}">Privacy
                                                Policy </a></li>
                                        <li> <a href="{{ route('frontend.pages.any.pages', 'terms-condition') }}">Terms
                                                of Service </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-box">
                                <div class="footer-title">
                                    <h5>CONTACT US</h5>
                                </div>
                                <div class="footer-contant">
                                    <p> Got Question? Call us 24/7 </p>
                                    <h3><a href="callto:8004301415" class="text-decoration-none">(800) 430-1415</a>
                                    </h3>
                                    <div class="mail-row">
                                        <p><a href="mailto:info@canably.com">info@canably.com</a> </p>
                                    </div>
                                    <p>2971 India St, San Diego, CA 92103</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-box">
                                <div class="footer-title">
                                    <h5>SUBSCRIBE NEWSLETTER</h5>
                                </div>
                                <div class="footer-contant">
                                    <div class="newsletter-second">
                                        <form action="post" class="newsletterForm" id="newsletterForm">
                                            <div class="form-row">
                                                <div class="form-group col-6">
                                                    <div class="input-group">
                                                        <input type="text" name="first_name" required
                                                            class="form-control"
                                                            placeholder="First name">
                                                    </div>
                                                </div>
                                                <div class="form-group col-6">
                                                    <div class="input-group">
                                                        <input type="text" name="last_name" required
                                                            class="form-control"
                                                            placeholder="Last name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="number" name="mobile_number" required
                                                        class="form-control"
                                                        placeholder="Mobile number">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="email" required class="form-control text-lowercase" placeholder="Email">
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-solid btn-sm">submit now</button>
                                                </div>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="subfooter">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="footer-left">
                        <p>Copyrights © {{ date('Y') }}. All Rights Reserved.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-right">
                        <p>Designed By
                            <span>
                                <a href="//shyamfuture.com" target="_blank">Digital SFTware</a>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer end -->
