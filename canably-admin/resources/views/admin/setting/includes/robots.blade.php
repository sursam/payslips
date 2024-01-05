<div class="row">
    <div class="col-md-12 order-1 order-md-1">
        <div class="tile">
            <form class="settingsForm" role="form" id="general-form">
                @csrf
                @method('PUT')
                <div class="space-y-8">
                    <div class="grid gap-5 md:grid-cols-1">
                        <div>
                            <label class="block text-sm font-medium mb-2" for="last_name">Robots Text</label>
                            <textarea class="form-input w-full robot_txt" rows="4" placeholder="Enter Robot code" id="robot_txt"
                                name="robot_txt">{{ (!empty(getSiteSetting('robot_txt')))  ? getSiteSetting('robot_txt') : ((file_exists(public_path('robots.txt'))) ? file_get_contents(public_path('robots.txt')) : '') }}
                            </textarea>
                            @error('robots-txt')
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
                            <span class="hidden xs:block ml-2">Update Robots.txt</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
