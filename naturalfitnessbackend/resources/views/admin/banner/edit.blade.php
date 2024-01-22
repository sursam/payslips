@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => true])
@push('styles')
    {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"> --}}
@endpush

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex">
                    <h1 class="col-6 m-0">Edit Banner</h1>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.cms.banner.list') }}" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.cms.banner.edit',$bannerData->uuid) }}" id="bannersubmit">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="url" required name="link" value="{{ $bannerData->link }}" class="form-control form-control-user" id="banner_link" placeholder="Banner Link">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" required name="order" value="{{ $bannerData->order }}" class="form-control form-control-user" id="order" placeholder="Order of appearance">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control form-control-uer col-lg-12" name="text" id="" cols="10"
                                        rows="5" placeholder="Please enter text to be shown on banner">{!! $bannerData->text !!}</textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" name="banner_image" class="custom-file-input form-control-user showOnUpload" data-show-loaction="imageBanner" id="banner_image" aria-describedby="banner_image" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                        <label class="custom-file-label" for="banner_image">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group text-center col-lg-12">
                                    <img class="img-fluid" width="200" height="200" id="showOnUpload" src="{{ $bannerData->display_image }}" alt="">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Save
                                </button>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
