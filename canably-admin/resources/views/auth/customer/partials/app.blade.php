<!DOCTYPE html>
<html lang="en">
@include('auth.customer.partials.header')
<body >
    @include('layouts.partials.flash')
    <div class="main-wrapper">
        <div class="login-bg">
            <div class="container">
                @yield('content')
            </div>
            @include('auth.customer.partials._footer')
        </div>
    </div>
    @include('auth.customer.partials.footer')
</body>
</html>



