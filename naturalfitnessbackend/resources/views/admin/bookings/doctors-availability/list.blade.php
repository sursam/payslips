@extends('admin.layouts.app', ['isNavbar' => true, 'isSidebar' => true, 'isFooter' => true])
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __("Doctor's Availabilities") }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2 availabilitiesdatatable" id="availabilitiesTable">
                <thead>
                    <tr class="text-uppercase">
                        <th>{{ __("Id") }}</th>
                        <th>{{ __("Doctor' Name") }}</th>
                        <th>{{ __("Today's Availability") }}</th>
                        <th>{{ __("Action") }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->

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
