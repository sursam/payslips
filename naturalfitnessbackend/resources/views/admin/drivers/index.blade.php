@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Manage Drivers') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.driver.add') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50 mr-1">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">{{ __('Add Driver') }}</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

            <ul class="nav nav-tabs mb-5">
                <li class="nav-item">
                    <h2 class="text-lg font-medium mr-auto">
                        <a href="{{ (!$type || $type == 'auto') ? '#' : ($status ? route('admin.driver.list', 'auto') . '?status='.$status : route('admin.driver.list', 'auto')) }}" class="nav-link {{ (!$type || $type == 'auto') ? 'active' : '' }}">
                            {{ __('Auto') }}
                        </a>
                    </h2>
                </li>
                <li class="nav-item">
                    <h2 class="text-lg font-medium mr-auto">
                        <a href="{{ ($type == 'bike') ? '#' : ($status ? route('admin.driver.list', 'bike') . '?status='.$status : route('admin.driver.list', 'bike')) }}" class="nav-link {{ ($type == 'bike') ? 'active' : '' }}">
                            {{ __('Bike') }}
                        </a>
                    </h2>
                </li>
                <li class="nav-item">
                    <h2 class="text-lg font-medium mr-auto">
                        <a href="{{ ($type == 'truck') ? '#' : ($status ? route('admin.driver.list', 'truck') . '?status='.$status : route('admin.driver.list', 'truck')) }}" class="nav-link {{ ($type == 'truck') ? 'active' : '' }}">
                            {{ __('Truck') }}
                        </a>
                    </h2>
                </li>
            </ul>
            <div class="filter-div">
                <div class="export-div">
                    <a href="{{ route('admin.driver.export', ['driver', $type]) }}" class="btn btn-sm btn-primary">Export</a>
                </div>
                <div class="status-div">
                    <label>{{ __('Status: ') }}</label>
                    <select class="form-control form-control-sm loaddata statusDropdown">
                        <option value="all" {{ ($status == 'all' || $status == '') ? 'selected' : ''}}>All</option>
                        <option value="active" {{ ($status == 'active') ? 'selected' : ''}}>Active</option>
                        <option value="pending" {{ ($status == 'pending') ? 'selected' : ''}}>Pending</option>
                    </select>
                </div>
                <table class="table table-report -mt-2 customdatatable" id="userTable" data-vtype="{{ !$type ? 'auto' : $type }}" >
                    <thead>
                        <tr class="text-uppercase">
                            <th>Id</th>
                            <th>Name</th>
                            <th>Contact</th>
                            {{--  <th>Drive With</th>  --}}
                            <th>Wallet Balance</th>
                            <th>Registration Date</th>
                            <th>Branding</th>
                            <th>Status</th>
                            <th>Suspension Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END: Data List -->

    </div>

@endsection

@push('scripts')
    <script>
        var userType = 'driver'
    </script>
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/js/datatableajax.js') }}"></script>
    <script src="{{ asset('assets/js/submit.js') }}"></script>
@endpush
