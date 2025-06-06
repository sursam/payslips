@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('Edit Business Types / Service Types') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.settings.categories.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">
        
        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Add Category Form -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.settings.categories.edit',$categoryData->uuid) }}" id="categorysubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5">
                        <div>
                            <label for="name-form-1" class="form-label">{{ __('Name') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <input type="text" required name="name" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" placeholder="Name" aria-label="Name" aria-describedby="basic-addon2" value="{{ $categoryData->name }}">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="p-5">
                        <div>
                            <label for="name-form-1" class="form-label">{{ __('Image') }} <span class="text-danger"><sup>*</sup></span></label></label>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input form-control-user showOnUpload" data-show-loaction="imageBanner" id="image" aria-describedby="image" accept="image/png,image/jpg,image/svg,image/webp,image/jpeg,image/gif">
                                    {{--  <label class="custom-file-label" for="image">Choose file</label>  --}}
                                </div>
                                @if($categoryData->image)
                                    <div class="form-group text-center col-lg-12">
                                        <img class="img-fluid" width="50" height="50" id="showOnUpload" src="{{ $categoryData->display_image }}" alt="">
                                    </div>
                                @endif
                            </div>
                            @error('image')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <input type="hidden" name="type" value="business">
                <button type="submit" class="btn btn-primary mt-4">Save</button>
            </form>
            <!-- END: Add Category Form -->
        </div>
    </div>

@endsection

@push('scripts')
@endpush