
<div class="row">
    <div class="col-md-12 order-1 order-md-1">
        <div class="tile">
            <form class="settingsForm" id="social-links-form" role="form">
                @csrf
                @method('PUT')
                <div class="space-y-8">
                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="currency_code">Facebook Url</label>
                            <input type="url" class="form-input w-full" placeholder="Enter Facebook URL" id="facebook_url" name="facebook_url" value="{{ getSiteSetting('facebook_url') }}" />
                            @error('facebook_url')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="currency_code">Twitter Url</label>
                            <input type="url" class="form-input w-full" placeholder="Enter Twitter URL" id="twitter_url" name="twitter_url" value="{{ getSiteSetting('twitter_url') }}" />
                            @error('twitter_url')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="currency_code">Instagram Url</label>
                            <input type="url" class="form-input w-full" placeholder="Enter Instagram URL" id="instagram_url" name="instagram_url" value="{{ getSiteSetting('instagram_url') }}" />
                            @error('instagram_url')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="currency_code">Linkedln Url</label>
                            <input type="url" class="form-input w-full" placeholder="Enter Linkedln URL" id="linkedln_url" name="linkedln_url" value="{{ getSiteSetting('linkedln_url') }}" />
                            @error('linkedln_url')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="currency_code">Google Url</label>
                            <input type="url" class="form-input w-full" placeholder="Enter Google URL" id="google_url" name="google_url" value="{{ getSiteSetting('google_url') }}" />
                            @error('google_url')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="currency_code">Yelp Url</label>
                            <input type="url" class="form-input w-full" placeholder="Enter Yelp URL" id="yelp_url" name="yelp_url" value="{{ getSiteSetting('yelp_url') }}" />
                            @error('yelp_url')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="space-y-8 mt-4">
                    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                        <!-- Add Admin button -->
                        <button class="btn bg-emerald-500 hover:bg-emerald-600 bg- text-white" type="submit"
                            id="btnSave">
                            <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                            </svg>
                            <span class="hidden xs:block ml-2">Update Social links</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
