@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => true])
@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-flex">
            <h1 class="col-6 m-0">Manage Banners</h1>
            <div class="col-6 text-right">
                <a href="{{ route('admin.cms.banner.add') }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add Banner</span>
                </a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <input type="hidden" name="dataUrl" class="dataUrl" value="getBanners">
            <div class="card-body">
                <div class="row" id="data-wrapper">

                </div>
                @include('layouts.partials.data-loader')
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('assets/js/scrollDataLoad.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <script>
        $(document).on("click", '.subject-imgbg', function(event) {
            event.preventDefault();
            $(this).find('.lightbox').ekkoLightbox();
        });
    </script>
@endpush
