@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            <span>{{ __('Settings') }}</span>
        </h2>
    </div>

    <div class="intro-y tab-content mt-5">
        <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
            <form class="settingsForm" method="POST" role="form" id="general-form">
                @csrf
                <div class="grid grid-cols-12 gap-6">
                    <div class="intro-y box col-span-12 lg:col-span-12">
                        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                {{ __("General Settings") }}
                            </h2>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-12 gap-6">
                                <div class="col-span-6 lg:col-span-12 2xl:col-span-12">
                                    <label for="name-form-1" class="form-label">Site Email</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="email" placeholder="Site Email"
                                        id="site_email" name="site_email" value="{{ getSiteSetting('site_email') }}" />
                                    </div>
                                    @error('site_email')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="intro-y box col-span-12 lg:col-span-12">
                        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                {{ __("Payment Settings") }}
                            </h2>

                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-12 gap-6">
                                <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                                    <label for="name-form-1" class="form-label">{{ __("Payment Mode") }}</label>
                                    <div class="radio-group mb-3">
                                        <label class="mr-2"><input class="radio-control mr-1" type="radio" name="payment_mode" value="sandbox" @checked(!getSiteSetting('payment_mode') || getSiteSetting('payment_mode') == 'sandbox')>Sandbox</label>
                                        <label><input class="radio-control mr-1" type="radio" name="payment_mode" value="live" @checked(getSiteSetting('payment_mode') == 'live')>Live</label>
                                    </div>
                                    @error('payment_mode')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-span-6 lg:col-span-12 2xl:col-span-12">
                                    <label for="name-form-1" class="form-label">{{ __("API Key") }}</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="number" placeholder="API Key"
                                        id="api_key" name="api_key" value="{{ getSiteSetting('api_key') }}" />
                                    </div>
                                    @error('api_key')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-span-6 lg:col-span-12 2xl:col-span-12">
                                    <label for="name-form-1" class="form-label">{{ __("API Secret") }}</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="number" placeholder="API Secret"
                                        id="api_secret" name="api_secret" value="{{ getSiteSetting('api_secret') }}" />
                                    </div>
                                    @error('api_secret')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary mt-4">Save</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
@endpush
