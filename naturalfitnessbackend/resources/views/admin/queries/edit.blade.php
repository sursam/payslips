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
            <a href="{{ route('admin.support.queries.queries-listing', $queriesData->user->uuid) }}" class="btn btn-warning btn-icon-split">
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
            <div class="queries_div_style">
                <label for="description-form-1" class="form-label">{{ __('Name') }} </label>
                <p>{{ $queriesData->user?->first_name ?? '' }} {{ $queriesData->user?->last_name ?? '' }}</p>
            </div>
            <div class="queries_div_style">
                <label for="description-form-1" class="form-label">{{ __('Queries Type') }} </label>
                <p>
                    @if ($queriesData->category_id == NULL)
                        {{ $queriesData->topic ?? '' }}
                    @else
                        {{ $queriesData->category?->name ?? '' }}
                    @endif
                </p>
            </div>
            <div class="queries_div_style">
                <label for="description-form-1" class="form-label">{{ __('Queries') }} </label>
                <p>
                    {{ $queriesData->question ?? '' }}
                </p>
            </div>
            @if (count($queriesData->supportAnswer)>0)
            <div class="queries_div_style">
                <label for="description-form-1" class="form-label">{{ __('Previous Answer') }} </label>
                @foreach ($queriesData->supportAnswer as $answer)
                    <p>
                        {{ $answer->answer ?? '' }}
                    </p>
                @endforeach
            </div>
            @endif
            <div class="queries_div_style">
                <form method="post"
                id="queriessubmit" action="{{ route('admin.support.queries.add-answer', $queriesData->uuid) }}">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="uuid" value="{{ $queriesData->uuid }}">
                    </div>
                    <div class="form-group">
                        <label for="description-form-1" class="form-label">{{ __('Answer') }} <span class="text-danger"><sup>*</sup></span></label>
                        <div class="col-sm-12">
                            <textarea required class="form-control form-control-user @error('answer') is-invalid @enderror" name="answer" id="queries_answer" placeholder="Answer" cols="20" rows="10" style="resize: none;"></textarea>
                        </div>
                        @error('description')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary mt-4" type="submit">Save</button>
                    </div>
                </form>
            </div>
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
