@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200">
            <input type="hidden" name="page_type" class="page_type" value="add">
            <form method="post" id="productForm" action="{{ route('admin.catalog.product.add') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="category_id" class="block text-sm font-medium mb-1">Category <span
                                    class="text-rose-500">*</span></label>
                            <select id="category_id" class="form-select" name="category_id">
                                <option value="">Select Category</option>
                                @forelse ($listCategories as $category)
                                    <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected @endif
                                        data-subcategory="{{ json_encode($category->descendants->pluck('name', 'path')) }}"
                                        data-attribute="{{ json_encode($category->attribute?->pluck('name', 'id')) }}">
                                        {{ $category->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @error('category_id')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="sub_category_id" class="block text-sm font-medium mb-1">Sub Category </label>
                            <select id="sub_category_id" class="form-select" name="sub_category_id">
                                <option value="">Sub Category</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-5 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Product Name <span
                                    class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full" type="text" name="name"
                                placeholder="Product Name" value="{{ old('name') }}" />
                            @error('name')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="title">Product Title</label>
                            <input id="title" class="form-input w-full" type="text" name="title"
                                placeholder="Product Title" value="{{ old('title') }}" />
                            @error('title')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name"> Product price($) <span
                                    class="text-rose-500">*</span></label>
                            <input id="price" class="form-input w-full basePrice" type="number" min="1"
                                step="any" name="price" placeholder="Product Price" value="{{ old('price') }}" />
                            @error('price')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div id="attributeData" class="card p-2 grid gap-5 md:grid-cols-2 d-none">

                    </div>
                    <div class="grid gap-5 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="discount">Product Discount</label>
                            <input id="discount" class="form-input w-full" type="number" step="any" name="discount"
                                placeholder="Product Discount" value="{{ old('discount') }}" />
                            @error('discount')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="vendor_id" class="block text-sm font-medium mb-1">Vendor Name <span
                                    class="text-rose-500">*</span></label>
                            <select id="vendor_id" class="form-select" name="vendor_id">
                                <option value="">Select Vendor</option>
                                @forelse ($listVendor as $vendor)
                                    <option value="{{ $vendor->id }}" @if (old('vendor_id') == $vendor->id) selected @endif>
                                        {{ $vendor->first_name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('vendor_id')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="brand_id" class="block text-sm font-medium mb-1">Brand Name <span
                                    class="text-rose-500">*</span></label>
                            <select id="brand_id" class="form-select" name="brand_id">
                                <option value="">Select Brand</option>
                                @forelse ($listBrands as $brand)
                                    <option value="{{ $brand->id }}" @if (old('brand_id') == $brand->id) selected @endif>
                                        {{ $brand->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('brand_id')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="is_featured" class="block text-sm font-medium mb-1">Featured <span
                                    class="text-rose-500">*</span></label>
                            <select id="is_featured" class="form-select" name="is_featured">
                                <option value="">Select Featured</option>
                                <option value="yes" @if (old('is_featured') == 'yes') selected @endif>Featured</option>
                                <option value="no" @if (old('is_featured') == 'no') selected @endif>Not Featured
                                </option>
                            </select>
                            @error('is_featured')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="tags"> Tags </label>
                            <input id="product_tag" class="form-input w-full" type="text" name="tags[product_tag]"
                                value="" />
                            <span class="text-sm">(Note:Tags does not contain space)</span>
                            @error('seo.meta_keyword')
                                {{--  <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>  --}}
                            @enderror
                        </div>
                        {{-- <div>
                            <label class="block text-sm font-medium mb-1" for="title">Product Specification <span
                                    class="text-rose-500">*</span></label>
                            <input id="specification" class="form-input w-full" type="text" name="specification"
                                placeholder="Product Specification" value="{{ old('specification') }}" />
                            @error('specification')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}

                        <div>
                            <label for="product_image" class="block text-sm font-medium mb-1">Product Image</label>
                            <input type="file" class="form-control" id="product_image" name="product_image[]"
                                accept="image/jpeg,image/png,image/jpg,image/gif" multiple>
                            @error('product_image')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-1">
                        <div>
                            <label class="block text-sm font-medium mb-2" for="last_name">Description</label>
                            <textarea class="form-input w-full" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="title">Meta Title </label>
                            <input id="seo[meta_title]" class="form-input w-full" type="text" name="seo[meta_title]"
                                placeholder="Meta Title" value="{{ old('seo.meta_title') }}" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="title">Meta Keywords </label>
                            <input id="seo[meta_keywords]" class="form-input w-full" type="text"
                                name="seo[meta_keywords]" placeholder="Meta Keywords"
                                value="{{ old('seo.meta_keywords') }}" />
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-1">
                        <div>
                            <label class="block text-sm font-medium mb-2" for="last_name">Meta Description</label>
                            <textarea class="form-input w-full not_editor" id="seo[meta_description]" name="seo[meta_description]"
                                rows="3"> {{ old('seo.meta_description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="space-y-8 mt-8">
                    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                        <!-- Add Admin button -->
                        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white addProduct" type="submit">
                            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z">
                                </path>
                            </svg>
                            <span class="hidden xs:block ml-2">Add</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/admin/js/product.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput.js') }}"></script>
    <script>
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword']) ? $seo['meta_keyword'] : ''; ?>";
        $('#product_tag').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#product_tag').tagsinput('add', meta_keyword_values);
    </script>
@endpush
