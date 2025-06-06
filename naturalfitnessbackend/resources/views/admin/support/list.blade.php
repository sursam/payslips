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
            {{ __('Manage Support Type') }}
        </h2>
        <div class="support_add_btn_style">
            {{-- <div class="col-6 text-right">
                <a href="{{ route('admin.support.type.add') }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50 mr-1">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">{{ __('Add New Support') }}</span>
                </a>
            </div> --}}
            <div class="col-6 text-right">
                <a href="{{ route('admin.support.type.group-add') }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50 mr-1">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">{{ __('Add New Support Type') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2 customdatatable">
                <thead>
                    <tr class="text-uppercase">
                        <th>Support Topic</th>
                        <th class="flex justify-end">Action</th>
                    </tr>
                </thead>
                @forelse ($categories as $category)
                    <tr>
                        <td>
                            {{ $category->name }}
                        </td>
                        <td>
                            <div class="flex justify-end items-center">
                                <a class="flex items-center mr-3"
                                    href="{{ route('admin.support.type.edit', $category->uuid) }}"><span
                                        class="icon text-white-50 mr-1"><i class="fas fa-edit"></i></span><span
                                        class="text">Edit</span></a>
                                <a class="flex items-center text-danger deleteData" href="javascript:void(0)"
                                    data-table="categories" data-uuid="{{ $category->uuid }}"><span
                                        class="icon text-white-50 mr-1"><i class="fas fa-trash"></i></span><span
                                        class="text">Delete</span></a>
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
