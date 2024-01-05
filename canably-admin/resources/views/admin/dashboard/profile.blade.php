@extends('admin.layouts.app')

@push('style')

@endpush
@section('content')
<div>
    @include('admin.layouts.partials.page-title')
    <div class="border-t border-slate-200">
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="space-y-8 mt-8">
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="email">Email <span class="text-rose-500">*</span></label>
                        <input id="email" class="form-input w-full" type="email" name="email" value="{{ auth()->user()->email }}" readonly disabled/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="mobile_number">Phone No</label>
                        <input id="mobile_number" class="form-input w-full" type="number" name="mobile_number" value="{{ auth()->user()->mobile_number }}" />
                        @error('mobile_number')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="first_name">First Name <span class="text-rose-500">*</span></label>
                        <input id="first_name" class="form-input w-full" type="text" name="first_name" placeholder="First Name" value="{{ auth()->user()->first_name }}" />
                        @error('first_name')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="last_name">Last Name <span class="text-rose-500">*</span></label>
                        <input id="last_name" class="form-input w-full" type="text" name="last_name" placeholder="Last Name" value="{{ auth()->user()->last_name }}" />
                        @error('last_name')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium mb-1">Gender <span class="text-rose-500">*</span></label>
                        <select id="gender" class="form-select" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" @if(auth()->user()->profile->gender == 'male') selected @endif>Male</option>
                            <option value="female" @if(auth()->user()->profile->gender == 'female') selected @endif>Female</option>
                            <option value="other" @if(auth()->user()->profile->gender == 'other') selected @endif>Others</option>
                        </select>
                    </div>
                    <div>
                        <label for="profile_image" class="block text-sm font-medium mb-1">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/jpg,image/gif">
                        @error('profile_image')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                 <div class="grid gap-5 md:grid-cols-1">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="password">Address </label>
                        <textarea class="form-control" rows="5" id="address" name="address">{{ auth()->user()->profile->address }}
                        </textarea>
                        @error('address')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
                {{-- <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="city" class="block text-sm font-medium mb-1">City <span class="text-rose-500">*</span></label>
                        <select id="city" class="form-select" name="city">
                            <option value="">Select City</option>
                            <option value="kolkata">kolkata</option>
                            <option value="mumbai">Mumbai</option>
                            <option value="jaipur">Jaipur</option>
                        </select>
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium mb-1">State <span class="text-rose-500">*</span></label>
                        <select id="state" class="form-select" name="state">
                            <option value="">Select State</option>
                            <option value="west bengal">West Bengal</option>
                            <option value="maharastrs">Maharastra</option>
                            <option value="rajasthgan">Rajasthan</option>
                        </select>
                    </div>
                </div> --}}
            </div>
            <div class="space-y-8 mt-8">
                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                    <!-- Add Admin button -->
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">
                        {{-- <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"></path>
                        </svg> --}}
                        <span class="hidden xs:block ml-2">Update</span>
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>
@endsection
@push('scripts')

@endpush
