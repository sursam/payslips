@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => true])
@push('styles')

@endpush

@section('content')

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex">
                    <h1 class="col-6 m-0">Edit Tool Type</h1>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.inventories.tags.list') }}" class="btn btn-warning btn-icon-split">
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
                                action="{{ route('admin.inventories.tags.edit',$tag->uuid) }}" id="categorysubmit">
                                @csrf
                                <div class="form-group">
                                    <input type="text" required name="name" class="form-control form-control-user"
                                        id="name" value="{{ $tag->name }}" placeholder="Tag Name">
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
