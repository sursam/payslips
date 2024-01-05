@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
    @include('admin.layouts.partials.page-title', ['backbutton' => true])
    <div class="border-t border-slate-200">
        <form method="post" action="{{ route('admin.banner.edit', $bannerData->uuid) }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-8 mt-8">
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="name">Name <span
                                class="text-rose-500">*</span></label>
                        <input id="name" class="form-input w-full" type="text" name="name"
                            value="{{ $bannerData->name }}" />
                        @error('name')
                            <div class="text-xs mt-1 text-rose-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label for="order" class="block text-sm font-medium mb-1">Select Order <span
                                class="text-rose-500">*</span></label>
                        <select id="order" class="form-select" name="order">
                            <option value="">Select Order</option>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" @if ($i == $bannerData->order) selected @endif>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        @error('order')
                            <div class="text-xs mt-1 text-rose-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- <div>
                        <label class="block text-sm font-medium mb-1" for="name">Banner Link <span
                                class="text-rose-500">*</span></label>
                        <input id="link" class="form-input w-full" type="url" name="link"
                            value="{{ $bannerData->link }}" />
                        @error('link')
                            <div class="text-xs mt-1 text-rose-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}
                </div>
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="order" class="block text-sm font-medium mb-1">Select Page <span
                                class="text-rose-500">*</span></label>
                        <select id="page" class="form-select page" name="page">
                            <option value="">Select page</option>
                            <option value="home" @if ($bannerData->page == 'home') selected @endif>Home page</option>
                            @forelse ($pages as $page)
                                <option value="{{ $page->slug }}" @if ($bannerData->page == $page->slug) selected @endif>
                                    {{ $page->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('page')
                            <div class="text-xs mt-1 text-rose-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label for="position" class="block text-sm font-medium mb-1">Select Position <span
                                class="text-rose-500">*</span></label>
                        <select id="position" class="form-select" name="position">
                            <option value="top" @if ($bannerData->position == 'top') selected @endif>Top</option>
                            <option value="middle" @if ($bannerData->position == 'middle') selected @endif>Middle</option>
                            <option value="bottom" @if ($bannerData->position == 'bottom') selected @endif>Bottom</option>
                        </select>
                        @error('position')
                            <div class="text-xs mt-1 text-rose-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="grid gap-5 md:grid-cols-1">
                    <div>
                        <label for="description" class="block text-sm font-medium mb-1">Description <span
                                class="text-rose-500">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3">{!! $bannerData->description !!}</textarea>
                        @error('description')
                            <div class="text-xs mt-1 text-rose-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="grid gap-3 md:grid-cols-2">
                    <div>
                        <label for="banner_image" class="block text-sm font-medium mb-1">Banner Image</label>
                        <input type="file" class="form-control" id="banner_image" name="banner_image"
                            accept="image/jpeg,image/png,image/jpg,image/gif">
                        @error('banner_image')
                            <div class="text-xs mt-1 text-rose-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="alt_text">Alt Tag </label>
                        <input id="alt_text" class="form-input w-full" type="text" name="alt_text"
                            value="{{ $bannerData->image->alt_text }}" />
                        @error('alt_text')
                            <div class="text-xs mt-1 text-rose-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="space-y-8 mt-8">
                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">
                        <span class="hidden xs:block ml-2">Update</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/admin/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/editor.js') }}"></script>
    <script>
        if ($('#page').val() != 'home') {
            $('#position,#order,#link').attr('disabled', true);
        } else {
            if ($('#position').val() != 'top') {
                $('#order').val(1).change();
                $('#order').attr('disabled', true);
            } else {
                $('#order').attr('disabled', false);
            }
            $('#position,#link').attr('disabled', false);
        }
        $('#page').change(function(e) {
            e.preventDefault();
            if ($(this).val() != 'home') {
                $('#position,#order,#link').attr('disabled', true);
            } else {
                if ($('#position').val() != 'top') {
                    $('#order').val(1).change();
                    $('#order').attr('disabled', true);
                } else {
                    $('#order').attr('disabled', false);
                }
                $('#position,#link').attr('disabled', false);
            }
        });
        $('#position').change(function(e) {
            e.preventDefault();
            if ($(this).val() != 'top') {
                $('#order').val(1).change();
                $('#order').attr('disabled', true);
            } else {
                $('#order').attr('disabled', false);
            }
        });
    </script>
@endpush
