@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
    <link href="{{ asset('assets/custom/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endpush
@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __("Update $userData->first_name's Availabilities") }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.booking.doctor.availability.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.booking.doctor.availability.alter', $userData->uuid) }}" id="questionsubmit">
        @csrf
        <div class="grid grid-cols-12 gap-6">
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2 customdatatable">
                    <thead>
                        <tr class="text-uppercase">
                            <th>&nbsp;</th>
                            <th>Available From</th>
                            <th>Available To</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($availabilityData as $available_day => $availabilities)
                            <tr>
                                <td>
                                    <div>
                                        <div class="input-group">
                                            <h2 class="text-lg font-medium mr-auto">{{ $available_day }}</h2>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <table class="table table-report intervalTable">
                                        @foreach ($availabilities as $availability)
                                            <tr class="appendRow">
                                                <td>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="text" name="available_from[{{ $available_day }}][]" value="{{ $availability->available_from ? \Carbon\Carbon::parse($availability->available_from)->format('h:i A') : '' }}" class="timepicker form-control" autocomplete="off">
                                                        </div>
                                                        @error('available_from')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="text" name="available_to[{{ $available_day }}][]" value="{{ $availability->available_to ? \Carbon\Carbon::parse($availability->available_to)->format('h:i A') : '' }}" class="timepicker form-control" autocomplete="off">
                                                        </div>
                                                        @error('available_to')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="flex items-center text-danger col-span-1 lg:col-span-1 2xl:col-span-1 removeBtn"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success col-span-2 lg:col-span-2 2xl:col-span-2 addInterval mb-2" data-day="{{ $available_day }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add Slot</a>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary mt-4">Update</button>
                </div>
            </div>
        </div>
    </form>
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
            $('input.timepicker').timepicker();
            $(document).on("click", ".addInterval", function() {
                let day = $(this).data('day');
                let innerHtml = '';
                innerHtml =
                    `<tr class="appendRow">
                        <td>
                            <div>
                                <div class="input-group">
                                    <input type="text" name="available_from[`+day+`][]" value="" class="timepicker form-control" autocomplete="off">
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="input-group">
                                    <input type="text" name="available_to[`+day+`][]" value="" class="timepicker form-control" autocomplete="off">
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="flex items-center text-danger col-span-1 lg:col-span-1 2xl:col-span-1 removeBtn"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                        </td>
                    </tr>`;
                $(this).closest('tr').find('table.intervalTable').append(innerHtml);
                $('input.timepicker').timepicker();
            });
            $(document).on("click", ".removeBtn", function() {
                if($(this).closest('table.intervalTable').find('tr.appendRow').length > 1){
                    $(this).closest('tr.appendRow').remove();
                }
            });
        });
    </script>
@endpush
