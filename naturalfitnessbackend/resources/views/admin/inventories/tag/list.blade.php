@extends('admin.layouts.app', ['isNavbar' => true, 'isSidebar' => true, 'isFooter' => true])
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex">
            <h1 class="col-6 m-0">Manage Types</h1>
            <div class="col-6 text-right">
                <a href="{{ route('admin.inventories.tags.add') }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add Type</span>
                </a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="col-6 sm-0 font-weight-bold text-primary">List Of Types</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered customdatatable" id="tagsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatableajax.js') }}"></script>
    <script src="{{ asset('assets/js/submit.js') }}"></script>
@endpush
