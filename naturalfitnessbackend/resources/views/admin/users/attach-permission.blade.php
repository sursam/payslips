@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8 mb-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('User Permissions') }}
        </h2>
        <div class="col-6 text-right">
            <a href="{{ route('admin.users.list','admin') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>   
    </div>
    <div class="grid grid-cols-12 gap-6">        
        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <div class="border-t border-slate-200">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col mb-2">
                        <div class="col-span-full sm:col-span-6 xl:col-span-4 shadow-lg rounded-sm">
                            <div class="flex flex-col h-full">
                                <!-- Card top -->
                                <div class="grow p-3 box">
                                    <!-- Bio -->
                                    <div class="mt-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" class="form-checkbox" name="permission[]" value="view-dashboard"
                                                @if ($user->can('view-dashboard')) checked @endif />
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
                        @forelse ($permissions as $chunk)
                            <!-- Card 1 -->
                            <div class="col-span-full sm:col-span-6 xl:col-span-3 shadow-lg rounded-sm">
                                <div class="flex flex-col h-full">
                                    <!-- Card top -->
                                    <div class="grow p-3 box">
                                        @forelse ($chunk as $permission)
                                            <div class="text-justify mt-2">
                                                <div class="text-sm">
                                                    <label class="flex items-center">
                                                        <input type="checkbox" class="form-checkbox" name="permission[]"
                                                            value="{{ $permission->slug }}"
                                                            @if ($user->can($permission->slug)) checked @endif />
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

                    </div>
                    <div class="space-y-8 mt-8">
                        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                            <!-- Add Admin button -->
                            <button type="submit" class="btn btn-primary mt-4">Attach</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
