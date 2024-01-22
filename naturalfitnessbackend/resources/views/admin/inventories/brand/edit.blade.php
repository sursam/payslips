@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => true])
@push('styles')
@endpush

@section('content')
{{-- @if ($errors->any())
{{ implode('', $errors->all('<div>:message</div>')) }}
@endif --}}
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex">
                    <h1 class="col-6 m-0">Add Brand</h1>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.inventories.brands.list') }}" class="btn btn-warning btn-icon-split">
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
                                action="{{ route('admin.inventories.brands.edit',$brandData->uuid) }}" id="brandsubmit">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <input type="text" required name="name" class="form-control form-control-user"
                                            id="name" placeholder="Brand Name" value="{{ old('name') ?? $brandData->name }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="url" required name="link" class="form-control form-control-user"
                                            id="link" placeholder="Brand Link" value="{{ old('link') ?? $brandData->link }}">
                                        @error('link')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <select name="is_popular" id="is_popular" class="form-control "
                                            placeholder="Select Popularity">
                                            <option value="">Select Popularity</option>
                                            <option value="1" @selected(old('is_popular')== 1 || $brandData->is_popular==1)>Yes</option>
                                            <option value="0" @selected(old('is_popular')== 0 || $brandData->is_popular==0 )>No</option>
                                        </select>
                                        @error('is_popular')
                                            <span class="d-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control form-control-uer col-lg-12" name="description" id="" cols="10"
                                        rows="5" placeholder="Please enter brand description">{{ old('description') ?? $brandData->description }}</textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" name="brand_image"
                                            class="custom-file-input form-control-user showOnUpload"
                                            data-show-loaction="imageBanner" id="brand_image"
                                            aria-describedby="brand_image"
                                            accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                        <label class="custom-file-label" for="brand_image">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group text-center col-lg-12">
                                    <img class="img-fluid" width="200" height="200" id="showOnUpload"
                                        src="{{ $brandData->display_image }}" alt="">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Save
                                </button>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
