@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush
@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Edit Question') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.medical.question.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Edit Question Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                action="{{ route('admin.medical.question.edit', $questionData->uuid) }}" id="questionsubmit">
                @csrf
                <div class="intro-y box lg:mt-5 grid grid-cols-12 gap-6 p-5">
                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                        <div>
                            <label for="name-form-1" class="form-label">{{ __('Question') }} <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group">
                                <input type="text" name="name"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="name" placeholder="Question" aria-label="Question"
                                    aria-describedby="basic-addon2" value="{{ $questionData->name }}">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                        <div>
                            <label for="type-form-1" class="form-label">{{ __('Type') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                <select name="type" id="type" class="form-control form-control-user questionType">
                                    <option value="">Select Type</option>
                                    <option value="normal" @selected($questionData->type == 'normal')>Normal</option>
                                    <option value="radio" @selected($questionData->type == 'radio')>Radio</option>
                                    <option value="checkbox" @selected($questionData->type == 'checkbox')>Checkbox</option>
                                </select>
                            </div>
                            @error('type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                        <div>
                            <label for="type-form-1" class="form-label">{{ __('Issue') }} <span class="text-danger"><sup>*</sup></span></label>
                            <div class="input-group">
                                @php
                                    //$issueCollection = collect($issues);
                                    $issueCollection = collect($questionData->issues->pluck('id'));
                                @endphp
                                @forelse ($issues as $issue)
                                    <div class="text-justify mt-2">
                                        <div class="text-sm">
                                            <label class="flex items-center mr-5">
                                                <input type="checkbox" class="form-checkbox" name="issues[]"
                                                    value="{{ $issue->id }}"
                                                    @checked($issueCollection->contains($issue->id)) />
                                                <span class="text-sm ml-2">{{ $issue->name }}</span>
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            @error('issues')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6 optionsBox" @if($questionData->options->count()) style="display:block;" @endif>
                        <div>
                            <div class="intro-y grid grid-cols-2">
                                <div class="col-6">
                                    <label for="type-form-1" class="form-label">{{ __('Options') }} <span class="text-danger"><sup>*</sup></span></label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success col-span-2 lg:col-span-2 2xl:col-span-2 addMore mb-2"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add More</a>
                                </div>
                            </div>
                            <div>
                                <div class="input-group">
                                    <div class="optionDiv w-100">
                                        @forelse($questionData->options as $option)
                                            <div class="appendDiv grid grid-cols-12 gap-4 pt-2 pb-2">
                                                <input type="text" class="form-control col-span-11 lg:col-span-11 2xl:col-span-11" name="option_value[]" placeholder="Option Value" value="{{ $option->option_value }}">
                                                <a href="javascript:void(0)" class="flex items-center text-danger col-span-1 lg:col-span-1 2xl:col-span-1 removeBtn"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @error('issues')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary mt-4">Update</button>
                </div>
            </form>
            <!-- END: Edit Question Form -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/submit.js') }}"></script>
    <script>
        $(document).on("click", ".addMore", function() {
            let innerHtml = '';
            innerHtml =
                `<div class="appendDiv grid grid-cols-12 gap-4 pt-2 pb-2"><input type="text" class="form-control col-span-11 lg:col-span-11 2xl:col-span-11" name="option_value[]" placeholder="Option Value"><a href="javascript:void(0)" class="flex items-center text-danger col-span-1 lg:col-span-1 2xl:col-span-1 removeBtn"><i class="fa fa-times-circle" aria-hidden="true"></i></a></div>`;
            $('.optionDiv').append(innerHtml);
        });
        $(document).on("click", ".removeBtn", function() {
            if($('.appendDiv').length > 1){
                $(this).closest('div.appendDiv').remove();
            }
        });
        $(document).on("change", ".questionType", function() {
            if($(this).val() == 'radio' || $(this).val() == 'checkbox'){
                $('.optionsBox').fadeIn();
            }else{
                $('.optionsBox').fadeOut();
            }
        });
    </script>
@endpush
