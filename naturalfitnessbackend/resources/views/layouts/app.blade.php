<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
@include('layouts.partials.header')
<body class="login">
    @include('layouts.partials.flash')
        <div class="container sm:px-10">
            @yield('content')
        </div>
        {{-- <x-switcher /> --}}
        @include('layouts.partials._footer')
</body>
</html>
