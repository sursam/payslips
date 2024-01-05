
{{-- @extends('admin.layouts.app')

@push('style')

@endpush
@section('content')
<div>
    <h2 class="text-2xl text-slate-800 font-bold mb-6">{{$pageTitle}}</h2>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div>
            <h2 class="text-2xl text-slate-800 font-bold mb-6">Permissions</h2>
            <form method="post">
                @csrf
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <!-- Start -->
                        <label class="flex items-center">
                            <input type="checkbox" class="form-checkbox" name="permission[]" value="view-dashboard" @if($roleData->hasPermission('view-dashboard')) checked @endif />
                            <span class="text-sm ml-2">View Dashboard Page</span>
                        </label>
                        <p class="font-weight-light text-small">N.B: If This is Not checked user will be redirected to Accounts Page</p>
                        <!-- End -->
                    </div>
                </div>

                <div class="flex flex-wrap-items-center -m-3">

                    @forelse ($permissions as $chunk )
                        <div class="card col-md-3 mr-2 mb-2">
                            @forelse ($chunk as $permission )
                                <div class="p-2">
                                    <!-- Start -->
                                    <label class="flex items-center">
                                        <input type="checkbox" class="form-checkbox" name="permission[]" value="{{ $permission->slug }}" @if($roleData->hasPermission($permission->slug)) checked @endif />
                                        <span class="text-sm ml-2">{{ $permission->name }}</span>
                                    </label>
                                    <!-- End -->
                                </div>
                            @empty

                            @endforelse
                        </div>
                    @empty

                    @endforelse
                </div>
                <div class="text-center mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-md">Submit</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush --}}


@extends('admin.layouts.app')

@push('style')

@endpush
@section('content')
    @include('admin.layouts.partials.page-title')
    <div class="border-t border-slate-200">
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="col mb-2">
                <div class="col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                    <div class="flex flex-col h-full">
                        <!-- Card top -->
                        <div class="grow p-3">
                            <!-- Bio -->
                            <div class="mt-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox" name="permission[]" value="view-dashboard" @if($roleData->hasPermission('view-dashboard')) checked @endif />
                                    <span class="text-sm ml-2">View Dashboard Page</span>
                                </label>
                                <div class="text-sm text-muted ml-2">
                                    * N.B: If This is Not checked user will be redirected to Accounts Page
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <!-- Users cards -->
                @forelse ($permissions as $chunk )
                    <!-- Card 1 -->
                    <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white shadow-lg rounded-sm border border-slate-200">
                        <div class="flex flex-col h-full">
                            <!-- Card top -->
                            <div class="grow p-3">
                                @forelse ($chunk as $permission )
                                <div class="text-justify mt-2">
                                    <div class="text-sm">
                                        <label class="flex items-center">
                                            <input type="checkbox" class="form-checkbox" name="permission[]" value="{{ $permission->slug }}" @if($roleData->hasPermission($permission->slug)) checked @endif />
                                            <span class="ml-2">{{ $permission->name }}</span>
                                        </label>
                                    </div>
                                </div>
                                @empty

                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse
                <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white shadow-lg rounded-sm border border-slate-200">
                    <div class="flex flex-col h-full">
                        <!-- Card top -->
                        <div class="grow p-3">
                            <div class="text-justify mt-2">
                                <div class="text-sm">
                                    <label class="flex items-center">
                                        <input type="checkbox" class="form-checkbox" name="permission[]" value="view-delivery" @if($roleData->hasPermission('view-delivery')) checked @endif />
                                        <span class="ml-2">View Delivery</span>
                                    </label>
                                </div>
                            </div>
                            <div class="text-justify mt-2">
                                <div class="text-sm">
                                    <label class="flex items-center">
                                        <input type="checkbox" class="form-checkbox" name="permission[]" value="edit-delivery" @if($roleData->hasPermission('edit-delivery')) checked @endif />
                                        <span class="ml-2">Edit Delivery</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-8 mt-8">
                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                    <!-- Add Admin button -->
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"></path>
                        </svg>
                        <span class="hidden xs:block ml-2">Attach</span>
                    </button>
                </div>
            </div>

        </form>
    </div>

@endsection
@push('scripts')

@endpush


