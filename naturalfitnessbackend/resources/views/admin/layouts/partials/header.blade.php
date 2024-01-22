<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (config('app.env') !== 'production')
        <meta name="robots" content="noindex, nofollow">
    @endif
    {{-- <link rel="icon" href="{{ asset('assets/frontend/images/favicon.ico') }}" type="image/x-icon"> --}}
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet" />
    <link href="//cdn.jsdelivr.net/npm/sweetalert2@11.6.14/dist/sweetalert2.min.css" />
    @stack('styles')
    <title>{{ config('app.name', 'Natural Fitness') . ' - ' . ($pageTitle ?? '') }}</title>
</head>
