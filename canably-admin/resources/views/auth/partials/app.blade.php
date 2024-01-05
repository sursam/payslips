<!DOCTYPE html>
<html lang="en">
@include('auth.partials.header')

<body class="font-inter antialiased bg-slate-100 text-slate-600 sidebar-expanded">
    @include('layouts.partials.flash')
    <script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>
    <main class="bg-white">
        <div class="relative flex">
            @yield('content')
        </div>
    </main>
    @include('auth.partials.footer')
</body>
</html>
