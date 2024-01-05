<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('customer.layouts.partials.header')
    <body>
        @include('layouts.partials.flash')
        @yield('verify')
        @if ($navbar)
            @include('frontend.layouts.partials.navbar')
        @endif
        @if (!isset($noContent))
        <section class="profile-dashboard-section">
            <div class="container">
                <div class="profile-dashboard">
                    <div class="row dashboard-responive">
                        @if ($sidebar)
                            @include('customer.layouts.partials.sidebar')
                        @endif
                        <div class="profile-dashboard-right">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        @if ($footer)
            @include('frontend.layouts.partials.footer')
        @endif

        @if (!isset($noContent))
            @include('frontend.layouts.partials.cart')
            @include('frontend.layouts.partials.settings')
        @endif
        @include('frontend.layouts.partials._footer')
    </body>
</html>

