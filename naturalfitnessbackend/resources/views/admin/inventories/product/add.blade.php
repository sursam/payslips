@extends('admin.layouts.app', ['isNavbar' => true, 'isSidebar' => true, 'isFooter' => true])
@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex">
                    <h1 class="col-6 m-0">Add Product</h1>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.inventories.products.list') }}" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-3">
                            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                                action="{{ route('admin.inventories.products.add') }}" id="categorysubmit">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="form-label font-weight-bold" for="name">Product Name <span
                                                class="text-danger"><sup>*</sup></span> </label>
                                        <input type="text" required name="name" class="form-control" id="name"
                                            placeholder="Product Name">
                                        @error('name')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label font-weight-bold" for="mnemonic">Menemonic <span
                                                class="text-danger"><sup>*</sup></span></label>
                                        <input type="text" required name="menemonic" class="form-control" id="menemonic"
                                            placeholder="Product Menemonic">
                                        @error('menemonic')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label class="form-label font-weight-bold" for="category">Category <span
                                                class="text-danger"><sup>*</sup></span></label>
                                        <select name="parent_category" required id="category"
                                            class="form-control getPopulate" placeholder="Select a category"
                                            data-location="sub_category" data-message="Sub Category">
                                            <option value="" selected>Select category</option>
                                            @forelse ($masterCategories as $category)
                                                <option value="{{ $category->uuid }}"
                                                    data-populate="{{ json_encode($category->children->pluck('name', 'uuid')) }}"
                                                    data-attribute="{{ json_encode($category->attributes->pluck('name', 'uuid')) }}">
                                                    {{ $category->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('category')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label font-weight-bold" for="sub_category">Sub Category</label>
                                        <select name="sub_category" id="sub_category" class="form-control">
                                            <option value="">Select Sub Category</option>
                                        </select>
                                        @error('sub_category')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label font-weight-bold" for="brand">Brand <span
                                                class="text-danger"><sup>*</sup></span></label>
                                        <select name="brand" id="brand" class="form-control">
                                            <option value="">Select Brand</option>
                                            @forelse ($brands as $brand)
                                                <option value="{{ $brand->uuid }}">{{ $brand->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('brand')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label class="form-label font-weight-bold" for="title">Product Price <span
                                                class="text-danger"><sup>*</sup></span></label>
                                        <input type="number" required name="price" step=".01"
                                            class="form-control basePrice" id="price" placeholder="Product Price">
                                        @error('price')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label font-weight-bold" for="title">List Price <span
                                                class="text-danger"><sup>*</sup></span></label>
                                        <input type="number" required name="list_price" step=".01"
                                            class="form-control basePrice" id="price" placeholder="List Price">
                                        @error('price')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label font-weight-bold" for="title">Special Price </label>
                                        <input type="number" name="special_price" step=".01"
                                            class="form-control basePrice" id="price" placeholder="Special Price">
                                        @error('price')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div id="attributeData"
                                    class="mx-0 py-2 border rounded border-dark form-group row d-none">
                                    {{-- Attributes will be populated here --}}
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="form-label font-weight-bold" for="rank_order">Rank Order <span
                                                class="text-danger"><sup>*</sup></span> </label>
                                        <input type="number" required name="rank_order" class="form-control"
                                            id="rank_order" placeholder="Rank Order">
                                        @error('rank_order')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label font-weight-bold" for="part_number">Part Number <span
                                                class="text-danger"><sup>*</sup></span></label>
                                        <input type="text" required name="part_number" class="form-control"
                                            id="part_number" placeholder="Part Number">
                                        @error('part_number')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="form-label font-weight-bold" for="is_popular">Popular or not <span
                                                class="text-danger"><sup>*</sup></span></label>
                                        <select name="is_popular" id="is_popular" class="form-control">
                                            <option value="">Select Popularity</option>
                                            <option value="0" @selected(old('is_popular') == 0)>No</option>
                                            <option value="1" @selected(old('is_popular') == 1)>Yes</option>
                                        </select>
                                        @error('is_popular')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label font-weight-bold" for="is_featured">Special or not <span
                                                class="text-danger"><sup>*</sup></span></label>
                                        <select name="is_featured" id="is_featured" class="form-control">
                                            <option value="">Select Speciality</option>
                                            <option value="0" @selected(old('is_featured') == 0)>No</option>
                                            <option value="1" @selected(old('is_featured') == 1)>Yes</option>
                                        </select>
                                        @error('is_featured')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="title">Tool Types </label>
                                    <select name="tags[]" id="typeSelect" class="form-control typeSelect" data-placeholder="Select Product Types" multiple>
                                        <option value="">Select Data</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="description">Features/ Description
                                    </label>
                                    <textarea class="form-control form-control-uer col-lg-12" name="description" id="description" cols="10"
                                        rows="5" placeholder="Please enter category description"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" name="product_image[]"
                                            class="custom-file-input form-control-user showMultipleOnUpload" multiple
                                            data-show-loaction="imageBanner" id="product_image"
                                            aria-describedby="product_image"
                                            accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                        <label class="custom-file-label" for="product_image">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group text-center col-lg-12" id="showMultipleOnUpload">

                                </div>
                                <h5 class="text-divider"><span>Meta Details(Seo Purpose)</span></h5>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="form-label font-weight-bold" for="seotitle">Meta Title</label>
                                        <input type="text" name="seo[meta_title]" class="form-control" id="seotitle"
                                            placeholder="Meta Title">
                                        @error('seo.meta_title')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label font-weight-bold" for="seokeyword">Meta Keyword</label>
                                        <input type="text" name="seo[meta_keywords]" class="form-control"
                                            id="seokeyword" placeholder="Meta Keywords">
                                        @error('seo.meta_keywords')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="seodescription">Meta Description
                                    </label>
                                    <textarea class="form-control form-control-uer col-lg-12" name="seo[meta_description]" id="seodescription"
                                        cols="10" rows="5" placeholder="Please enter meta description"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Add
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('assets/js/product.js') }}"></script>
    <script>
        var meta_keyword_values = "{{ old('seo.meta_keyword') ?? '' }}";
        $('#seokeyword').tagsinput({
            confirmKeys: [13, 32, 44],
            focusClass: 'form-control'
        });
        $('#seokeyword').tagsinput('add', meta_keyword_values);
    </script>
@endpush