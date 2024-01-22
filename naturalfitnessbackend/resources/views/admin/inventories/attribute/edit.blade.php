@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => true])
@push('styles')
    {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"> --}}
@endpush

@section('content')
    {{-- @if ($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif --}}
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex">
                    <h1 class="col-6 m-0">Edit Attribute</h1>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.inventories.attributes.list') }}" class="btn btn-warning btn-icon-split">
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
                        <div class="p-3">
                            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                                action="{{ route('admin.inventories.attributes.edit',$attribute->uuid) }}" id="categorysubmit">
                                @csrf
                                <div class="form-group">
                                    <input type="text" required name="name" class="form-control form-control-user" value="{{ $attribute->name }}"
                                        id="name" placeholder="Attribute Name">
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
