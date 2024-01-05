<header class="sticky top-0 bg-white border-b border-slate-200 z-30">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">

            <!-- Header: Left side -->
            <div class="flex">


            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">



                <!-- Divider -->
                <hr class="w-px h-6 bg-slate-200" />

                <!-- User button -->
                <div class="relative inline-flex" x-data="{ open: false }">
                    <button class="inline-flex justify-center items-center group" aria-haspopup="true"
                        @click.prevent="open = !open" :aria-expanded="open">
                        <img class="w-8 h-8 rounded-full" src="{{ asset('assets/admin/images/user-avatar-32.png') }}"
                            width="32" height="32" alt="User" />
                        <div class="flex items-center truncate">
                            <span class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">Canably Inc.</span>
                            <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400" viewBox="0 0 12 12">
                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                            </svg>
                        </div>
                    </button>
                    <div class="origin-top-right z-10 absolute top-full right-0 min-w-44 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak>
                        <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-slate-200">
                            <div class="font-medium text-slate-800">Canably Inc.</div>
                            <div class="text-xs text-slate-500 italic">Administrator</div>
                        </div>
                        <ul>
                            <li>
                                <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                    href="{{ route('admin.change-password') }}" @click="open = false" @focus="open = true"
                                    @focusout="open = false">Change Password</a>
                            </li>
                            <li>
                                <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                    href="{{ url('admin/logout') }}" @click="open = false" @focus="open = true"
                                    @focusout="open = false">Sign Out</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
</header>
