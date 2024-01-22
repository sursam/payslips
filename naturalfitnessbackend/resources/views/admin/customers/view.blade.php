@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            <span>{{ __('Customer Details') }}</span>            
            {{--  <a href="{{ route('admin.users.customer.edit', $userData->uuid) }}" class="btn-sm">
                <span class="icon text-white-50">
                    <i class="fas fa-pencil"></i>
                </span>
                <span class="text">Edit</span>
            </a>  --}}
        </h2>
        <div class="text-right">
            <a href="{{ route('admin.customer.list') }}" class="btn btn-warning btn-icon-split mr-2">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    @if($userData->image)
                        <img class="img-fluid" height="150" id="showOnUpload" src="{{ $userData->profile_picture }}">
                    @else
                        <img class="img-fluid" height="150" id="showOnUpload" src="{{ asset('assets/images/profile-15.jpg') }}" alt="">
                    @endif
                    
                    {{--  <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2"> <i class="w-4 h-4 text-white" data-lucide="camera"></i> </div>  --}}
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">
                        {{ $userData->first_name . ' ' . $userData->last_name }}
                    </div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        @if($userData->profile?->occupation)
                            <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="briefcase" class="w-4 h-4 mr-2"></i> {{ $userData->profile?->occupation }} </div>
                        @endif    
                        @if($userData->profile?->gender)
                            <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> {{ $userData->profile?->gender }} </div>
                        @endif   
                    </div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $userData->email }} </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="phone" class="w-4 h-4 mr-2"></i> {{ $userData->mobile_number }} </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Profile Info -->

    

@endsection

@push('scripts')
@endpush
