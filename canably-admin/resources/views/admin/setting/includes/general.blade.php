 <div class="row">
     <div class="col-md-12 order-1 order-md-1">
         <div class="tile">
             <form class="settingsForm" action="{{ route('ajax.update.settings') }}" method="POST" role="form" id="general-form">
                 @csrf
                 @method('PUT')
                 <div class="space-y-8">
                     <div class="grid gap-3 md:grid-cols-2">
                         <div>
                             <label class="block text-sm font-medium mb-1" for="name">Site Name</label>
                             <input type="text" class="form-input w-full" placeholder="Enter site name" id="site_name"
                                 name="site_name" value="{{ getSiteSetting('site_name') }}" />
                             @error('site_name')
                                 <div class="text-xs mt-1 text-rose-500">
                                     {{ $message }}
                                 </div>
                             @enderror
                         </div>
                         <div>
                             <label class="block text-sm font-medium mb-1" for="name">Site Title</label>
                             <input class="form-input w-full" type="text" placeholder="Enter site title"
                                 id="site_title" name="site_title" value="{{ getSiteSetting('site_title') }}" />
                             @error('site_title')
                                 <div class="text-xs mt-1 text-rose-500">
                                     {{ $message }}
                                 </div>
                             @enderror
                         </div>
                         <div>
                             <label class="block text-sm font-medium mb-1" for="name">Page Url</label>
                             <input class="form-input w-full" type="url" placeholder="Enter page url" id="page_url"
                                 name="page_url" value="{{ getSiteSetting('page_url') }}" />
                             @error('page_url')
                                 <div class="text-xs mt-1 text-rose-500">
                                     {{ $message }}
                                 </div>
                             @enderror
                         </div>
                         <div>
                             <label class="block text-sm font-medium mb-1" for="name">Default Email Address</label>
                             <input class="form-input w-full" type="email" placeholder="Enter default email address"
                                 id="default_email_address" name="default_email_address"
                                 value="{{ getSiteSetting('default_email_address') }}" />
                             @error('default_email_address')
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
                         <button class="btn bg-emerald-500 hover:bg-emerald-600 bg- text-white" type="submit" id="btnSave">
                             <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                 <path
                                     d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                             </svg>
                             <span class="hidden xs:block ml-2">Update Settings</span>
                         </button>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </div>
