@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    @php
        $seo = $pageData->seo ? $pageData->seo->body : '';
    @endphp
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Edit Page') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.cms.page.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">
        
        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Add Page Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.cms.page.edit',$pageData->uuid) }}" id="pagesubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5">
                        <div>
                            <label for="name-form-1" class="form-label">{{ __('Page Name') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="text" required name="name" class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="name" placeholder="Page Name" aria-label="Page Name" aria-describedby="basic-addon2" value="{{ $pageData->name }}">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <label for="title-form-1" class="form-label">{{ __('Page Title') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="text" required name="title" class="form-control form-control-user @error('title') is-invalid @enderror"
                                    id="title" placeholder="Page Title" aria-label="Page Title" aria-describedby="basic-addon2" value="{{ $pageData->title }}">
                            </div>
                            @error('title')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description-form-1" class="form-label">{{ __('Page Content') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="col-sm-12">
                                <textarea class="form-control form-control-user @error('description') is-invalid @enderror" name="description" id="description" placeholder="Page Content" cols="20" rows="10">{{ $pageData->description }}</textarea>
                            </div>
                            @error('description')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="intro-y lg:mt-5">
                    <h2 class="text-lg font-medium mr-auto">Meta Details</h2>
                </div>
                <div class="intro-y box lg:mt-5">
                    <div class="p-5">
                        <div>
                            <label for="meta-title-form-1" class="form-label">{{ __('Meta Title') }}</label></label>
                            <div class="input-group mb-3">
                                <input type="text" name="seo[meta_title]" class="form-control form-control-user" id="name" placeholder="Meta Title" value="{{ $seo ? $seo['meta_title'] : '' }}">
                            </div>
                        </div>
                        <div>
                            <label for="meta-keyword-form-1" class="form-label">{{ __('Meta Keyword') }} </label></label>
                            <div class="input-group mb-3">
                                <input type="text" name="seo[meta_keywords]" class="form-control form-control-user" id="meta_keyword" placeholder="Meta Keyword" value="{{ $seo ? $seo['meta_keywords'] : '' }}">
                            </div>
                        </div>
                        <div>
                            <label for="meta-description-form-1" class="form-label">{{ __('Meta Description') }} </label></label>
                            <div class="input-group mb-3">
                                <textarea class="form-control meta_description" name="seo[meta_description]" id="meta-description" placeholder="Meta Description" cols="10" rows="5">{{ $seo ? $seo['meta_description'] : '' }}</textarea>
                            </div>
                        </div>                        
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Save</button>
            </form>
            <!-- END: Add Page Form -->
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/editor.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-tagsinput.js') }}"></script>
    <script>
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword']) ? $seo['meta_keyword'] : ''; ?>";
        $('#meta_keyword').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#meta_keyword').tagsinput('add', meta_keyword_values);
    </script>
@endpush