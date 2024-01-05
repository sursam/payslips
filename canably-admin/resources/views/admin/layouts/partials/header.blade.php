<head>
    <meta charset="utf-8">
    <title>Canably Admin -{{ $pageTitle ?? '' }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" />
    <link href="{{ asset('assets/admin/css/vendors/flatpickr.min.css') }}" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link href="{{ asset('assets/admin/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="//cdn.jsdelivr.net/npm/sweetalert2@11.6.14/dist/sweetalert2.min.css"  />
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet"  />
    {{-- <link href="{{ asset('assets/admin/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    @stack('style')
    <script>
        var APP_URL = {!! json_encode(url('/')) !!};
        var TOAST_POSITION = 'bottom-right';
    </script>
</head>
