<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<title>{{ $pageTitle ?? '' }}</title>
@include('layouts.partials.header')

<body class="font-inter antialiased bg-slate-100 text-slate-600" :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div>
            @include('layouts.partials.sidebar')
        </div>
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <!-- Site navbar -->
            @include('layouts.partials.navbar')
            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @include('layouts.partials.footer')


    @stack('scripts')
</body>

</html>
