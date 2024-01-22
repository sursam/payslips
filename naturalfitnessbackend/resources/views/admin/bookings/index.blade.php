@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Manage Bookings') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.booking.add') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text ml-1">{{ __('Create Booking') }}</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

            <div class="filter-div">
                {{--  <div class="grid grid-cols-12 gap-6">
                    <div id="" class="col-span-12 lg:col-span-6"></div>
                    <div id="" class="col-span-12 lg:col-span-6">
                        <div class="daterange-div text-right">
                            <label>{{ __('Filter by date: ') }}</label>
                            <input type="text" class="form-control daterange" name="daterange" autocomplete="off"/>
                        </div>
                    </div>
                </div>
                <div class="status-div">
                    <label>{{ __('Status: ') }}</label>
                    <select class="form-control form-control-sm loaddata bookingStatusDropdown">
                        <option value="all" {{ ($status == 'all' || $status == '') ? 'selected' : ''}}>All</option>
                        <option value="booked" {{ ($status == 'booked') ? 'selected' : ''}}>Booked</option>
                        <option value="cancelled" {{ ($status == 'cancelled') ? 'selected' : ''}}>Cancelled</option>
                        <option value="attended" {{ ($status == 'attended') ? 'selected' : ''}}>Attended</option>
                        <option value="absent" {{ ($status == 'absent') ? 'selected' : ''}}>Absent</option>
                    </select>
                </div>  --}}
                <table class="table table-report -mt-2 customdatatable" id="bookingTable" data-status="{{ $status }}">
                    <thead>
                        <tr class="text-uppercase">
                            <th>Id</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>issue</th>
                            <th>Booking Date</th>
                            <th>Amount</th>
                            <th>Status</th>
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
        var userType = 'driver';
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
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                autoUpdateInput: false,
                //allowClear: true,
                locale: {
                    format: 'YYYY-MM-DD h:mm A',
                    //cancelLabel: 'Clear'
                }
            },
            function (start, end) {
                $('input[name="daterange"]').val(start.format('YYYY-MM-DD h:mm A') + ' - ' + end.format('YYYY-MM-DD h:mm A'));
            });
        });
    </script>
@endpush
