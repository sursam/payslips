<head>
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" />
    <meta charset="utf-8">
    <title>Canably - {{$pageTitle ?? '' }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"/>
    <link href="{{ asset('assets/admin/css/vendors/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
