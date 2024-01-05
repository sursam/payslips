@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
@php
    $seo= $pageData->seo ? $pageData->seo->body : '';
@endphp
<div>
    @include('admin.layouts.partials.page-title')
    <div class="border-t border-slate-200">
        <form method="post" action="{{ route('admin.page.edit',$pageData->uuid) }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-8 mt-8">
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="name">Name <span class="text-rose-500">*</span></label>
                        <input id="name" class="form-input w-full" type="text" name="name" value="{{ $pageData->name }}" />
                        @error('name')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="title">Title <span class="text-rose-500">*</span></label>
                        <input id="title" class="form-input w-full" type="text" name="title" value="{{ $pageData->title }}" />
                        @error('title')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="grid gap-5 md:grid-cols-1 @if ($pageData->slug=='home'||$pageData->slug=='contact-us'||$pageData->slug=='store-locator'||$pageData->slug=='become-driver'||$pageData->slug=='faqs')
                    d-none
                @endif">
                    <div>
                        <label for="description" class="block text-sm font-medium mb-1">Description </label>
                        <textarea class="form-control" id="description" name="description" rows="3">
                            {{ $pageData->description }}
                        </textarea>
                        @error('description')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="meta_title">Meta Title</label>
                        <input id="meta_title" class="form-input w-full" type="text" name="seo[meta_title]" value="{{ $seo ? $seo['meta_title'] : '' }}" />
                        @error('seo.meta_title')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="meta_keyword"> Meta Keywords </label>
                        <input id="meta_keyword" class="form-input w-full" type="text" name="seo[meta_keyword]" value="{{ $seo ? $seo['meta_keyword'] : '' }}" />
                        @error('seo.meta_keyword')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="grid gap-5 md:grid-cols-1">
                    <div>
                        <label for="description" class="block text-sm font-medium mb-1">Meta Description </label>
                        <textarea class="form-input w-full not_editor" id="description" name="seo[meta_description]" rows="3">
                            {{ $seo ? $seo['meta_description'] : '' }}
                        </textarea>
                        @error('seo.meta_description')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="space-y-8 mt-8">
                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                    <!-- Add Admin button -->
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">
                        <span class="hidden xs:block ml-2">Update</span>
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/admin/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/editor.js')}}"></script>
    <script  src="{{asset('assets/plugins/bootstrap-tagsinput.js')}}"></script>
    <script >
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword'])?$seo['meta_keyword']:''; ?>";
        $('#meta_keyword').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#meta_keyword').tagsinput('add',meta_keyword_values);
    </script>
@endpush


