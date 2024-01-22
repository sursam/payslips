@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Incomplete Registrations') }}
        </h2>
        <div class="col-6 text-right">
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

            <div class="filter-div">
                <div class="export-div">
                    <a href="{{ route('admin.driver.export', ['driver', 'all', 0]) }}" class="btn btn-sm btn-primary">Export</a>
                </div>
                <table class="table table-report -mt-2 customdatatable" id="unregisteredDriverTable" data-vtype="{{ !$type ? 'auto' : $type }}" data-action="full">
                    <thead>
                        <tr class="text-uppercase">
                            <th>Id</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Registration Date</th>
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
