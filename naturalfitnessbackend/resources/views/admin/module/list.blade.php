@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Module') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.grant.settings.module.add') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">{{ __('Add New Module') }}</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2 customdatatable" id="applicationFormTable">
                <thead>
                    <tr class="text-uppercase">
                        <th>Id</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th class="flex justify-center items-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($module)
                        @foreach ($module as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value['title'] ?? '' }}</td>
                                <td>{{ $value['is_active'] == 1 ? 'Active' : 'In-Active' }}</td>
                                <td>
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center mr-3"
                                            href="{{ url('admin/grant/settings/module/edit', [$value['uuid']]) }}"><span
                                                class="icon text-white-50"><i class="fas fa-edit"></i></span><span
                                                class="text">Edit</span></a>
                                        <a href="{{ url('admin/grant/settings/module/field-list', [$value['uuid']]) }}"
                                            class="flex items-center mr-3"><span class="icon text-white-50"><i
                                                    class="fas fa-eye"></i></span><span class="text">Field</span></a>
                                        <a class="flex items-center text-danger deleteTableData" href="javascript:void(0);"
                                            data-table="modules" data-uuid="{{ $value['uuid'] }}"><span
                                                class="icon text-white-50"><i class="fas fa-trash"></i></span><span
                                                class="text">Delete</span></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>No Data Found</td>
                        </tr>
                    @endif
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
    <script src="{{ asset('assets/js/grant.js') }}"></script>
    <script src="{{ asset('assets/js/submit.js') }}"></script>
@endpush
