<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('frontend.layouts.partials.header')

<body>
    @include('layouts.partials.flash')
    <div class="main-wrapper">
        @if ($navbar)
            @include('frontend.layouts.partials.navbar')
        @endif

        @yield('content')

        @include('frontend.layouts.partials.settings')
        @include('frontend.layouts.partials.account')
        @include('frontend.layouts.partials.cart')
        @if ($footer)
            @include('frontend.layouts.partials.footer')
        @endif
    </div>
    <x-modals.disclaimer />

    @include('frontend.layouts.partials._footer')
    <script>
        /* $(document).ready(function() {
            $('#disclaimerModal').modal('show');
        }); */
    </script>
</body>

</html>
