@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    {{--  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.css') }}">  --}}
    <link href="{{ asset('assets/custom/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> --}}
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Manage Queries') }}
        </h2>
        <div class="support_add_btn_style">
            <a href="{{ route('admin.support.queries.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2 customdatatable">
                <thead>
                    <tr class="text-uppercase">
                        <th>Quaries Type</th>
                        <th>Quaries</th>
                        <th class="flex justify-end">Action</th>
                    </tr>
                </thead>
                @forelse ($queries as $query)
                    <tr>
                        <td>
                            @if ($query->category_id == NULL)
                                {{ $query->topic }}
                            @else
                                {{ $query->category?->name }}
                            @endif
                        </td>
                        <td>
                            {{ Str::limit($query->question, 65, '...') }}
                        </td>
                        <td>
                            <div class="flex justify-end items-center">
                                <a class="flex items-center mr-3"
                                    href="{{ route('admin.support.queries.add-answer', $query->uuid) }}"><span
                                        class="icon text-white-50 mr-1"><i class="fa-regular fa-eye"></i></span><span
                                        class="text">View</span></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            <p>{{ __('No data is available') }}</p>
                        </td>
                    </tr>
                @endforelse
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
    {{--  <script src="{{ asset('assets/js/datatableajax.js') }}"></script>  --}}
    <script src="{{ asset('assets/js/submit.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('input.timepicker').timepicker({});
        });
    </script>
@endpush
