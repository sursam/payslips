<head>
    <title>Canably - {{ $pageTitle }} {{ $subTitle ? '-' . $subTitle : '' }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @if (isset($meta) && !empty($meta))
        @foreach ($meta as $metaKey => $metaValue)
            <meta name="{{ str_replace('meta_', '', $metaKey) }}" content="{{ $metaValue }}">
        @endforeach
    @endif
    <meta name="description" content="big-deal">
    <meta name="keywords" content="big-deal">
    <meta name="author" content="big-deal">
    {{--  (when the server goes to production it should be on)  --}}
    {{--  @if (config('app.env') !== 'production')  --}}
    <meta name="robots" content="noindex, nofollow">
    {{--  @endif  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" type="image/x-icon" />

    <!--Google font-->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Nunito+Sans:wght@600;700;800;900&display=swap"
        rel="stylesheet">

    <!--icon css-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/font-awesome.min.css') }}">


    <!--Slick slider css-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick-theme.css') }}">

    <!--Animate css-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.css') }}">
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"/>

    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/style.css') }}" media="screen"
        id="color">
    @stack('styles')
    <script>
        var APP_URL = {!! json_encode(url('/')) !!};
        var TOAST_POSITION = 'bottom-right';
    </script>
</head>
