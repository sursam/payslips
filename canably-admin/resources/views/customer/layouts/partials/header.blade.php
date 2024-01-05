<head>
    <title>Canably -{{ $pageTitle ?? '' }}{{ $subTitle ? ' - '.$subTitle : '' }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if(isset($meta) && !empty($meta))
    @foreach($meta as $metaKey => $metaValue)
    <meta name="{{ str_replace('meta_','',$metaKey) }}" content="{{ $metaValue }}">
    @endforeach
    @endif

    @if (config('app.env') !== 'production')
    <meta name="robots" content="noindex, nofollow">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link href="//fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Nunito+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/frontend/css/plaza-font.css') }}"> --}}
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet"  />
    {{-- <link rel="stylesheet" href="{{ asset('assets/frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/fancy-box.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/jqueryui.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    @stack('style')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">

    <script>
        var APP_URL = {!! json_encode(url('/')) !!};
        var TOAST_POSITION = 'bottom-right';
    </script>
</head>
