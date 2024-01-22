@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link href="{{ asset('assets/custom/css/style.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Manage Helper Fares') }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2 customdatatable">
                <thead>
                    <tr class="text-uppercase">
                        <th>Helper Count</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($helperFares as $fare)
                        <tr>
                            <td>
                                {{ $fare->count }}
                            </td>
                            <td>
                                &#8377; {{ $fare->amount . ' / Day' }}
                            </td>
                            <td>
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3 helper_fare_edit_btn" href="javascript:void(0)"
                                        data-value="{{ json_encode($fare) }}"
                                        data-uuid="{{ $fare->uuid }}"><span
                                            class='icon text-white-50 mr-1'><i
                                                class="fas fa-edit"></i></span><span
                                            class="text">Edit</span></a>
                                    <a class="flex items-center text-danger deleteData" href="javascript:void(0)"
                                        data-table="helpewr_fares" data-uuid="{{ $fare->uuid }}"><span
                                            class="icon text-white-50 mr-1"><i
                                                class="fas fa-trash"></i></span><span
                                            class="text">Delete</span></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse

                    <tr>
                        <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                            action="{{ route('admin.helper-fare.alter') }}" id="helperfaresubmit">
                            @csrf
                            <td>
                                <div class="row-dsp-fixed">
                                    <div class="col-md-12 col-dsp-size">
                                        <label for="title-form-1" class="form-label">{{ __('Count') }} <span
                                                class="text-danger"><sup>*</sup></span></label></label>
                                        <div class="input-group mb-3">
                                            <input type="number" required name="count"
                                                class="form-control count form-control-user @error('count') is-invalid @enderror"
                                                placeholder="Count" aria-label="Count"
                                                aria-describedby="basic-addon2" autocomplete="off">
                                        </div>
                                        @error('count')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row-dsp-fixed">
                                    <div class="col-md-12 col-dsp-size">
                                        <label for="description-form-1" class="form-label">{{ __('Rate') }}
                                            <span class="text-danger"><sup>*</sup></span></label></label>
                                        <div class="input-group mb-3">
                                            <input type="number" required name="amount"
                                                class="form-control amount form-control-user @error('amount') is-invalid @enderror"
                                                placeholder="Rate" aria-label="Rate"
                                                aria-describedby="basic-addon2" autocomplete="off">
                                        </div>
                                        @error('amount')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row-dsp-fixed">
                                    <div class="col-md-2 col-dsp-btn-size input-group mb-3">
                                        <input type="hidden" name="id" class="fare_id">
                                        <button class="btn btn-primary btn-icon-split submit-btn" type="submit">
                                            Add
                                        </button>
                                    </div>
                                    <div class="col-md-2 input-group">
                                        <a href="javascript:void(0)" class="col-dsp-cls-btn helper_fare_edit_btn_hide">
                                            <i class="fa-solid fa-x"></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </form>
                    </tr>

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
    <script src="{{ asset('assets/js/submit.js') }}"></script>
    <script src="{{ asset('assets/js/admin.js') }}"></script>
@endpush
