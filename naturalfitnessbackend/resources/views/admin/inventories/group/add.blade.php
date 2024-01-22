@extends('admin.layouts.app', ['isNavbar' => true, 'isSidebar' => true, 'isFooter' => true])
@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex">
                    <h1 class="col-6 m-0">Add Group</h1>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.inventories.group.list') }}" class="btn btn-warning btn-icon-split">
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
                                action="{{ route('admin.inventories.group.add') }}" id="categorysubmit">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="title">Tool Types </label>
                                    <select name="types[]" id="typeSelect" class="form-control typeSelect" data-placeholder="Select Product Types" multiple required>
                                        <option value="">Select Data</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Add
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/product.js') }}"></script>
@endpush
