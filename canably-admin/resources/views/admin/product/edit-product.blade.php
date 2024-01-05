@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
    @php
        $seo = $productData->seo ? $productData->seo->body : '';
        $tags= $productData->tags;
        $product_tags= !empty($tags) ?  $tags['product_tag'] : '';
    @endphp
    <div>
        @include('admin.layouts.partials.page-title',['backbutton'=>true])
        <div class="border-t border-slate-200">
            <input type="hidden" name="page_type" class="page_type" value="edit">
            <form method="post" action="{{ route('admin.catalog.product.edit', $productData->uuid) }}"
                enctype="multipart/form-data" id="productForm">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="category_id" class="block text-sm font-medium mb-1">Category <span class="text-rose-500">*</span></label>
                            <select id="category_id" class="form-select" name="category_id">
                                <option value="">Select Category</option>
                                @forelse ($listMasterCategories as $category)
                                <option value="{{ $category->id }}" data-subcategory="{{ json_encode($category->children?->pluck('name', 'id')) }}" data-attribute="{{ json_encode($category->attribute?->pluck('name', 'id')) }}" @if ($productData->category_id == $category->id || $productData->category->rootAncestor?->id == $category->id) selected @endif>{{ $category->name }}</option>
                            @empty
                            @endforelse
                            </select>
                            @error('category_id')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="hidden" name="sub_categoryid" class="sub_category_id" value="{{ $productData->sub_category_id }}">
                        <div>
                            <label for="sub_category_id" class="block text-sm font-medium mb-1">Sub Category </label>
                            <select id="sub_category_id" class="form-select" name="sub_category_id">
                                <option value="">Select Sub Category</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-5 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Product Name <span
                                    class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full" type="text" name="name"
                                placeholder="Product Name" value="{{ $productData->name }}" />
                            @error('name')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="title">Product Title</label>
                            <input id="title" class="form-input w-full" type="text" name="title"
                                placeholder="Product Title" value="{{ $productData->title }}" />
                            @error('title')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Product price<span
                                    class="text-rose-500">*</span></label>
                            <input id="price" class="form-input w-full basePrice" type="number" min="1" step="any"
                                name="price" placeholder="Product Price" value="{{ $productData->price }}" />
                            @error('price')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" value="{{ json_encode($productData->specifications) }}" name="product_attributes" id="product_attributes">
                    <div id="attributeData" class="card p-2 grid gap-5 md:grid-cols-2">
                    </div>
                    <div class="grid gap-5 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="discount">Product Discount</label>
                            <input id="discount" class="form-input w-full" type="number" min="1" step="any"
                                name="discount" placeholder="Product Discount" value="{{ $productData->discount }}" />
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
                                <option value="1" @if($productData->vendor_id==1 ) selected @endif>Canably Vendor(Admin Own)</option>
                                @forelse ($listVendor as $vendor)
                                <option value="{{ $vendor->id }}" @if ($productData->vendor_id && $productData->vendor_id == $vendor->id) selected @endif>
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
                                <option value="{{ $brand->id }}" @if ($productData->brand_id && $productData->brand_id == $brand->id) selected @endif>
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
                            <label for="is_featured" class="block text-sm font-medium mb-1">Featured <span class="text-rose-500">*</span></label>
                            <select id="is_featured" class="form-select" name="is_featured">
                                <option value="">Select Featured</option>
                                <option value="yes" @if ($productData->is_featured == 'yes') selected @endif>Featured</option>
                                <option value="no" @if ($productData->is_featured == 'no') selected @endif>Not Featured
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
                    <div class="grid gap-5 md:grid-cols-3 text-center">
                        @forelse ($productData->product_images as $key => $image)
                            <div class="card position-relative" style="max-width: 80%">
                                <!-- other elements -->
                                <div>
                                    <a class="text-right position-absolute top-0 end-0 border rounded-circle @if($key!=0) removeMedia @else pe-none @endif" data-uuid="{{ $key }}"><i class="fas fa-times"></i></a>
                                    <img src="{{ $image }}" class="img-fluid img-thumbnail" alt="product image" style="width:100%;object-fit:cover">
                                </div>


                          </div>
                        @empty

                        @endforelse
                    </div>
                    <div class="grid gap-5 md:grid-cols-1">
                        <div>
                            <label class="block text-sm font-medium mb-2" for="last_name">Description</label>
                            <textarea class="form-input w-full" id="description" name="description" rows="3">{{ $productData->description }}</textarea>
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
                                placeholder="Meta Title" value="{{ $seo ? $seo['meta_title'] : '' }}" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="title">Meta Keywords </label>
                            <input id="seo[meta_keywords]" class="form-input w-full" type="text"
                                name="seo[meta_keywords]" placeholder="Meta Keywords" value="{{ $seo ? $seo['meta_keywords'] : '' }}" />
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-1">
                        <div>
                            <label class="block text-sm font-medium mb-2" for="last_name">Meta Description</label>
                            <textarea class="form-input w-full not_editor" id="seo[meta_description]" name="seo[meta_description]"
                                rows="3">{{ $seo ? $seo['meta_description'] : '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="space-y-8 mt-8">
                    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                        {{-- <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white editProduct" type="submit">
                            <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z"></path>
                            </svg>
                            <span class="hidden xs:block ml-2">Update</span>
                        </button> --}}
                        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white editProduct" type="submit">
                            <svg class="w-4 h-4 fill-current text-white shrink-0" viewBox="0 0 16 16">
                                <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z"></path>
                            </svg>
                            <span class="ml-2">Update</span>
                        </button>
                    </div>
                </div>


            </form>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{asset('assets/admin/js/product.js')}}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput.js') }}"></script>
    <script>
        var tag_values = "<?php echo !empty($product_tags) ? $product_tags : ''; ?>";
        $('#product_tag').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#product_tag').tagsinput('add', tag_values);
    </script>
@endpush
