<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
@include('layouts.partials.header')

<body class="py-5">
    @include('layouts.partials.flash')
    @if (isMobileDevice())
        @include('admin.layouts.partials.mobile-sidebar')
    @endif
    <div class="flex mt-[4.7rem] md:mt-0">
        @if ($isSidebar)
            @include('admin.layouts.partials.sidebar')
        @endif
        <div class="content">
            @if ($isNavbar)
                @include('admin.layouts.partials.navbar')
            @endif
            @yield('content')
        </div>
    </div>

    {{--  <x-switcher />  --}}
    @include('admin.layouts.partials._footer')
</body>

</html>
