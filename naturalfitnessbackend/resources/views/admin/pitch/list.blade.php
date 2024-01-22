@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" integrity="sha512-0V10q+b1Iumz67sVDL8LPFZEEavo6H/nBSyghr7mm9JEQkOAm91HNoZQRvQdjennBb/oEuW+8oZHVpIKq+d25g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Pitch') }}
        </h2>
        {{-- <div class="col-6 text-right">
            <a href="{{ route('admin.settings.module.add') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">{{ __('Add New Pich') }}</span>
            </a>
        </div> --}}
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2 customdatatable" id="applicationFormTable">
                <thead>
                    <tr class="text-uppercase">
                        <th>Id</th>
                        <th>Pitch Id</th>
                        <th>Company Name</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th class="flex justify-center items-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($pitch)
                        @foreach ($pitch as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->uuid }}</td>
                                <td>{{ $value->company?->company_name }}</td>
                                <td>{{ $value['is_active'] == 1 ? 'Active' : 'In-Active' }}</td>
                                <td>{{ date('dS M Y',strtotime($value->created_at)) }}</td>
                                <td>
                                    <div class="flex justify-center items-center">
                                        <a target="_blank" class="flex items-center mr-3"
                                            href="{{ url('admin/grant/pitch/view', [$value['uuid']]) }}"><span
                                                class="icon text-white-50"><i class="fas fa-eye"></i></span><span
                                                class="text">&nbsp;View</span></a>
                                        <a href="javascript:void(0)" class="operations" data-id="{{$value['uuid']}}">Accept/Reject</a>
                                        
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
