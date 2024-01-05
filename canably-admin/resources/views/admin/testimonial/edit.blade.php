@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.testimonial.edit', $testimonial->uuid) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="space-y-8 mt-8">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="order" class="block text-sm font-medium mb-1">User Name <span class="text-rose-500">*</span></label>
                                <input id="name" class="form-input w-full" type="text" name="name" placeholder="Name"
                                    value="{{ $testimonial->name }}" />
                                @error('name')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="order" class="block text-sm font-medium mb-1">Product <span class="text-rose-500">*</span></label>
                                <input id="product" class="form-input w-full" type="text" name="product" placeholder="Product Name"
                                    value="{{ $testimonial->product }}" />
                                @error('product')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="grid gap-5 md:grid-cols-1">
                            <div>
                                <label for="testimonial_image" class="block text-sm font-medium mb-1">Testimonial Image</label>
                                <input type="file" class="form-control" id="testimonial_image" name="testimonial_image"
                                    accept="image/jpeg,image/png,image/jpg,image/gif">
                                @error('testimonial_image')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="grid gap-5 md:grid-cols-1">
                            <div>
                                <label for="comment" class="block text-sm font-medium mb-1">Comment <span class="text-rose-500">*</span></label>
                                <textarea class="form-control" id="comment" name="comment" rows="3">
                                {{ $testimonial->comment }}
                            </textarea>
                                @error('comment')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
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
    <script src="{{ asset('assets/admin/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/editor.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput.js') }}"></script>
    <script>
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword']) ? $seo['meta_keyword'] : ''; ?>";
        $('#meta_keyword').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#meta_keyword').tagsinput('add', meta_keyword_values);
    </script>
@endpush
