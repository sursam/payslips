@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Add Role
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.settings.role.list') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-home"></i>
                </span>
                <span class="text">Go Back</span>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: Change Password -->
            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" id="categorysubmit">
                @csrf
                <div class="intro-y box lg:mt-5">
                    <div class="p-5">
                        <div>
                            <label for="name" class="form-label">Name <span
                                    class="text-danger"><sup>*</sup></span></label></label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Role Name" aria-label="Role Name" aria-describedby="basic-addon2"
                                name="name">
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary mt-4">Add Role</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END: Change Password -->
        </div>
    </div>
@endsection

@push('scripts')
@endpush
