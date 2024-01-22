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
            {{ __('Manage Fares') }}
        </h2>
        {{-- <div class="col-6 text-right">
            <a href="{{ route('admin.fare.add') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50 mr-1">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">{{ __('Add New Fare') }}</span>
            </a>
        </div> --}}
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2 customdatatable">
                <thead>
                    <tr class="text-uppercase">
                        <th>Vehicle Type</th>
                        <th>Hours Range</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td colspan="4">
                                <div style="display: flex; gap: 10px;">
                                    <span><img src="{{ $category->display_image }}" style='width:30px; height:30px;'></span><span style="display: flex; align-items: center;">{{ $category->name }}</span>
                                </div>
                            </td>
                        </tr>

                        @forelse ($category->fares as $fare)
                            <tr>
                                <td></td>
                                <td>
                                    {{ date('h:i A', strtotime($fare->start_at)) . ' - ' . date('h:i A', strtotime($fare->end_at)) }}
                                    </h2>
                                </td>
                                <td>
                                    &#8377; {{ $fare->amount . '/km' }}
                                </td>
                                <td>
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center mr-3 fare_edit_btn" href="javascript:void(0)"
                                            data-value="{{ json_encode($fare) }}"
                                            data-catid="{{ $category->uuid }}"><span
                                                class='icon text-white-50 mr-1'><i
                                                    class="fas fa-edit"></i></span><span
                                                class="text">Edit</span></a>
                                        <a class="flex items-center text-danger deleteData" href="javascript:void(0)"
                                            data-table="fares" data-uuid="{{ $fare->uuid }}"><span
                                                class="icon text-white-50 mr-1"><i
                                                    class="fas fa-trash"></i></span><span
                                                class="text">Delete</span></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        @if (!count($category->subCategory))
                            <tr id="fare_{{ $category->uuid }}">
                                <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                                    action="{{ route('admin.fare.alter') }}" id="faresubmit_{{ $category->uuid }}">
                                    @csrf
                                    <td></td>
                                    <td>
                                        <div class="row-dsp-fixed">
                                            <div class="col-md-6 col-dsp-size">
                                                <label for="title-form-1" class="form-label">{{ __('Start Time') }} <span
                                                        class="text-danger"><sup>*</sup></span></label></label>
                                                <div class="input-group mb-3">
                                                    <input type="text" required name="start_at"
                                                        class="form-control start_at timepicker form-control-user @error('title') is-invalid @enderror"
                                                        placeholder="Start Time" aria-label="Start Time"
                                                        aria-describedby="basic-addon2" autocomplete="off">
                                                </div>
                                                @error('title')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-dsp-size">
                                                <label for="description-form-1" class="form-label">{{ __('End Time') }}
                                                    <span class="text-danger"><sup>*</sup></span></label></label>
                                                <div class="input-group mb-3">
                                                    <input type="text" required name="end_at"
                                                        class="form-control end_at timepicker form-control-user @error('title') is-invalid @enderror"
                                                        placeholder="End Time" aria-label="End Time"
                                                        aria-describedby="basic-addon2" autocomplete="off">
                                                </div>
                                                @error('description')
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
                                                <label for="description-form-1" class="form-label">{{ __('Rate/Km') }}
                                                    <span class="text-danger"><sup>*</sup></span></label></label>
                                                <div class="input-group mb-3">
                                                    <input type="text" required name="amount"
                                                        class="form-control amount form-control-user @error('title') is-invalid @enderror"
                                                        placeholder="Rate" aria-label="Rate"
                                                        aria-describedby="basic-addon2"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        autocomplete="off">
                                                </div>
                                                @error('description')
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
                                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                                <button class="btn btn-primary btn-icon-split submit-btn" type="submit">
                                                    Add
                                                </button>
                                            </div>
                                            <div class="col-md-2 input-group">
                                                <a href="javascript:void(0)" class="col-dsp-cls-btn fare_edit_btn_hide"
                                                    data-catid="{{ $category->uuid }}">
                                                    <i class="fa-solid fa-x"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                        @endif
                        @forelse ($category->subCategory as $subCategory)
                            @if($subCategory->type != 'vehicle_body')
                                <tr>
                                    <td colspan="4">
                                        {{-- <h2 class="vtype-title">{{ $subCategory->name }}</h2> --}}
                                        <div style="display: flex; gap: 10px;">
                                            <span><img src="{{ $subCategory->display_image }}" style='width:30px; height:30px;'></span><span style="display: flex; align-items: center;">{{ $subCategory->name }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @forelse ($subCategory->fares as $fare)
                                    <tr>
                                        <td></td>
                                        <td>
                                            {{ date('h:i A', strtotime($fare->start_at)) . ' - ' . date('h:i A', strtotime($fare->end_at)) }}
                                            </h2>
                                        </td>
                                        <td>
                                            &#8377; {{ $fare->amount . '/km' }}
                                        </td>
                                        <td>
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3 fare_edit_btn" href="javascript:void(0)"
                                                    data-value="{{ json_encode($fare) }}"
                                                    data-catid="{{ $subCategory->uuid }}"><span
                                                        class='icon text-white-50 mr-1'><i
                                                            class="fas fa-edit"></i></span><span
                                                        class="text">Edit</span></a>
                                                <a class="flex items-center text-danger deleteData"
                                                    href="javascript:void(0)" data-table="fares"
                                                    data-uuid="{{ $fare->uuid }}"><span class="icon text-white-50 mr-1"><i
                                                            class="fas fa-trash"></i></span><span
                                                        class="text">Delete</span></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                <tr id="fare_{{ $subCategory->uuid }}">
                                    <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                                        action="{{ route('admin.fare.alter') }}" id="faresubmit_{{ $subCategory->uuid }}">
                                        @csrf
                                        <td></td>
                                        <td>
                                            <div class="row-dsp-fixed">
                                                <div class="col-md-6 col-dsp-size">
                                                    <label for="title-form-1" class="form-label">{{ __('Start Time') }}
                                                        <span class="text-danger"><sup>*</sup></span></label></label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" required name="start_at"
                                                            class="form-control start_at timepicker form-control-user @error('title') is-invalid @enderror"
                                                            placeholder="Start Time" aria-label="Start Time"
                                                            aria-describedby="basic-addon2" autocomplete="off">
                                                    </div>
                                                    @error('title')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 col-dsp-size">
                                                    <label for="description-form-1" class="form-label">{{ __('End Time') }}
                                                        <span class="text-danger"><sup>*</sup></span></label></label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" required name="end_at"
                                                            class="form-control end_at timepicker form-control-user @error('title') is-invalid @enderror"
                                                            placeholder="End Time" aria-label="End Time"
                                                            aria-describedby="basic-addon2" autocomplete="off">
                                                    </div>
                                                    @error('description')
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
                                                    <label for="description-form-1" class="form-label">{{ __('Rate/Km') }}
                                                        <span class="text-danger"><sup>*</sup></span></label></label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" required name="amount"
                                                            class="form-control amount form-control-user @error('title') is-invalid @enderror"
                                                            placeholder="Rate" aria-label="Rate"
                                                            aria-describedby="basic-addon2"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            autocomplete="off">
                                                    </div>
                                                    @error('description')
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
                                                    <input type="hidden" name="category_id" value="{{ $subCategory->id }}">
                                                    <button class="btn btn-primary btn-icon-split submit-btn"
                                                        type="submit">
                                                        Add
                                                    </button>
                                                </div>
                                                <div class="col-md-2 input-group">
                                                    <a href="javascript:void(0)" class="col-dsp-cls-btn fare_edit_btn_hide"
                                                        data-catid="{{ $subCategory->uuid }}">
                                                        <i class="fa-solid fa-x"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                            @endif
                        @empty
                        @endforelse

                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <p>{{ __('No data is available') }}</p>
                            </td>
                        </tr>
                    @endforelse
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
