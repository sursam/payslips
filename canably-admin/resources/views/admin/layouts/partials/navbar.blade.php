<!-- Site header -->
<header class="sticky top-0 bg-white border-b border-slate-200 z-30">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">
            <!-- Header: Left side -->
            <div class="flex">
                <!-- Hamburger button -->
                <button class="text-slate-500 hover:text-slate-600 lg:hidden" @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar" :aria-expanded="sidebarOpen">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="5" width="16" height="2" />
                        <rect x="4" y="11" width="16" height="2" />
                        <rect x="4" y="17" width="16" height="2" />
                    </svg>
                </button>

            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">

                {{-- <!-- Search button -->
                <div x-data="{ searchOpen: false }">
                    <!-- Button -->
                    <button
                        class="w-8 h-8 flex items-center justify-center bg-slate-100 hover:bg-slate-200 transition duration-150 rounded-full"
                        :class="{ 'bg-slate-200': searchOpen }"
                        @click.prevent="searchOpen = true;if (searchOpen) $nextTick(()=>{$refs.searchInput.focus()});"
                        aria-controls="search-modal">
                        <span class="sr-only">Search</span>
                        <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-current text-slate-500"
                                d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path class="fill-current text-slate-400"
                                d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                    <!-- Modal backdrop -->
                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="searchOpen"
                        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true"
                        x-cloak></div>
                    <!-- Modal dialog -->
                    <div id="search-modal"
                        class="fixed inset-0 z-50 overflow-hidden flex items-start top-20 mb-4 justify-center px-4 sm:px-6"
                        role="dialog" aria-modal="true" x-show="searchOpen"
                        x-transition:enter="transition ease-in-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
                        <div class="bg-white overflow-auto max-w-2xl w-full max-h-full rounded shadow-lg"
                            @click.outside="searchOpen = false" @keydown.escape.window="searchOpen = false">
                            <!-- Search form -->
                            <form class="border-b border-slate-200">
                                <div class="relative">
                                    <label for="modal-search" class="sr-only">Search</label>
                                    <input id="modal-search"
                                        class="w-full border-0 focus:ring-transparent placeholder-slate-400 appearance-none py-3 pl-10 pr-4"
                                        type="search" placeholder="Search Products…" x-ref="searchInput" />
                                    <button class="absolute inset-0 right-auto group" type="submit"
                                        aria-label="Search">
                                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-4 mr-2"
                                            viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                            <path
                                                d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                            <div class="py-4 px-2">
                                <!-- Recent searches -->
                                <div class="mb-3 last:mb-0">
                                    <div class="text-xs font-semibold text-slate-400 uppercase px-2 mb-2">Recent
                                        searches</div>
                                    <ul class="text-sm">
                                        <li>
                                            <a class="flex items-center p-2 text-slate-800 hover:text-white hover:bg-indigo-500 rounded group"
                                                href="#0" @click="searchOpen = false" @focus="searchOpen = true"
                                                @focusout="searchOpen = false">
                                                <svg class="w-4 h-4 fill-current text-slate-400 group-hover:text-white group-hover:text-opacity-50 shrink-0 mr-3"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z" />
                                                </svg>
                                                <span>Elevate Gummies Delta 8 350mg – 35ct</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="flex items-center p-2 text-slate-800 hover:text-white hover:bg-indigo-500 rounded group"
                                                href="#0" @click="searchOpen = false" @focus="searchOpen = true"
                                                @focusout="searchOpen = false">
                                                <svg class="w-4 h-4 fill-current text-slate-400 group-hover:text-white group-hover:text-opacity-50 shrink-0 mr-3"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z" />
                                                </svg>
                                                <span>Day Bear (CBD/CBG/CBC/THCV)</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="flex items-center p-2 text-slate-800 hover:text-white hover:bg-indigo-500 rounded group"
                                                href="#0" @click="searchOpen = false" @focus="searchOpen = true"
                                                @focusout="searchOpen = false">
                                                <svg class="w-4 h-4 fill-current text-slate-400 group-hover:text-white group-hover:text-opacity-50 shrink-0 mr-3"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z" />
                                                </svg>
                                                <span>Happy Shaman Delta 8 THC Prerolls</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="flex items-center p-2 text-slate-800 hover:text-white hover:bg-indigo-500 rounded group"
                                                href="#0" @click="searchOpen = false" @focus="searchOpen = true"
                                                @focusout="searchOpen = false">
                                                <svg class="w-4 h-4 fill-current text-slate-400 group-hover:text-white group-hover:text-opacity-50 shrink-0 mr-3"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z" />
                                                </svg>
                                                <span>Hawaiian Haze Delta 8 THC Pre-roll</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="flex items-center p-2 text-slate-800 hover:text-white hover:bg-indigo-500 rounded group"
                                                href="#0" @click="searchOpen = false" @focus="searchOpen = true"
                                                @focusout="searchOpen = false">
                                                <svg class="w-4 h-4 fill-current text-slate-400 group-hover:text-white group-hover:text-opacity-50 shrink-0 mr-3"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z" />
                                                </svg>
                                                <span>Clean AF 500mg CBD Disposable Vape MAX</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="flex items-center p-2 text-slate-800 hover:text-white hover:bg-indigo-500 rounded group"
                                                href="#0" @click="searchOpen = false" @focus="searchOpen = true"
                                                @focusout="searchOpen = false">
                                                <svg class="w-4 h-4 fill-current text-slate-400 group-hover:text-white group-hover:text-opacity-50 shrink-0 mr-3"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z" />
                                                </svg>
                                                <span>Torch Haymaker Live Resin Disp. Vape 2.2ml </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications button -->
                <div class="relative inline-flex" x-data="{ open: false }">
                    <button
                        class="w-8 h-8 flex items-center justify-center bg-slate-100 hover:bg-slate-200 transition duration-150 rounded-full"
                        :class="{ 'bg-slate-200': open }" aria-haspopup="true" @click.prevent="open = !open"
                        :aria-expanded="open">
                        <span class="sr-only">Notifications</span>
                        <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-current text-slate-500"
                                d="M6.5 0C2.91 0 0 2.462 0 5.5c0 1.075.37 2.074 1 2.922V12l2.699-1.542A7.454 7.454 0 006.5 11c3.59 0 6.5-2.462 6.5-5.5S10.09 0 6.5 0z" />
                            <path class="fill-current text-slate-400"
                                d="M16 9.5c0-.987-.429-1.897-1.147-2.639C14.124 10.348 10.66 13 6.5 13c-.103 0-.202-.018-.305-.021C7.231 13.617 8.556 14 10 14c.449 0 .886-.04 1.307-.11L15 16v-4h-.012C15.627 11.285 16 10.425 16 9.5z" />
                        </svg>
                        <div class="absolute top-0 right-0 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full">
                        </div>
                    </button>
                    <div class="origin-top-right z-10 absolute top-full right-0 -mr-48 sm:mr-0 min-w-80 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak>
                        <div class="text-xs font-semibold text-slate-400 uppercase pt-1.5 pb-2 px-4">Notifications
                        </div>
                        <ul>
                            <li class="border-b border-slate-200 last:border-0">
                                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false"
                                    @focus="open = true" @focusout="open = false">
                                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                                        sunt in culpa qui officia deserunt mollit anim.</span>
                                    <span class="block text-xs font-medium text-slate-400">Feb 12, 2021</span>
                                </a>
                            </li>
                            <li class="border-b border-slate-200 last:border-0">
                                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false"
                                    @focus="open = true" @focusout="open = false">
                                    <span class="block text-sm mb-2">📣 <span class="font-medium text-slate-800">Edit
                                            your information in a swipe</span> Sint occaecat cupidatat non proident,
                                        sunt in culpa qui officia deserunt mollit anim.</span>
                                    <span class="block text-xs font-medium text-slate-400">Feb 9, 2021</span>
                                </a>
                            </li>
                            <li class="border-b border-slate-200 last:border-0">
                                <a class="block py-2 px-4 hover:bg-slate-50" href="#0" @click="open = false"
                                    @focus="open = true" @focusout="open = false">
                                    <span class="block text-sm mb-2">🚀<span class="font-medium text-slate-800">Say
                                            goodbye to paper receipts!</span> Sint occaecat cupidatat non proident, sunt
                                        in culpa qui officia deserunt mollit anim.</span>
                                    <span class="block text-xs font-medium text-slate-400">Jan 24, 2020</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Info button -->
                <div class="relative inline-flex" x-data="{ open: false }">
                    <button
                        class="w-8 h-8 flex items-center justify-center bg-slate-100 hover:bg-slate-200 transition duration-150 rounded-full"
                        :class="{ 'bg-slate-200': open }" aria-haspopup="true" @click.prevent="open = !open"
                        :aria-expanded="open">
                        <span class="sr-only">Info</span>
                        <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-current text-slate-500"
                                d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                        </svg>
                    </button>
                    <div class="origin-top-right z-10 absolute top-full right-0 min-w-44 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak>
                        <div class="text-xs font-semibold text-slate-400 uppercase pt-1.5 pb-2 px-3">Need help?</div>
                        <ul>
                            <li>
                                <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                    href="#0" @click="open = false" @focus="open = true"
                                    @focusout="open = false">
                                    <svg class="w-3 h-3 fill-current text-indigo-300 shrink-0 mr-2"
                                        viewBox="0 0 12 12">
                                        <rect y="3" width="12" height="9" rx="1" />
                                        <path d="M2 0h8v2H2z" />
                                    </svg>
                                    <span>Documentation</span>
                                </a>
                            </li>
                            <li>
                                <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                    href="#0" @click="open = false" @focus="open = true"
                                    @focusout="open = false">
                                    <svg class="w-3 h-3 fill-current text-indigo-300 shrink-0 mr-2"
                                        viewBox="0 0 12 12">
                                        <path
                                            d="M10.5 0h-9A1.5 1.5 0 000 1.5v9A1.5 1.5 0 001.5 12h9a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0010.5 0zM10 7L8.207 5.207l-3 3-1.414-1.414 3-3L5 2h5v5z" />
                                    </svg>
                                    <span>Support Site</span>
                                </a>
                            </li>
                            <li>
                                <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                    href="#0" @click="open = false" @focus="open = true"
                                    @focusout="open = false">
                                    <svg class="w-3 h-3 fill-current text-indigo-300 shrink-0 mr-2"
                                        viewBox="0 0 12 12">
                                        <path
                                            d="M11.854.146a.5.5 0 00-.525-.116l-11 4a.5.5 0 00-.015.934l4.8 1.921 1.921 4.8A.5.5 0 007.5 12h.008a.5.5 0 00.462-.329l4-11a.5.5 0 00-.116-.525z" />
                                    </svg>
                                    <span>Contact us</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}

                <!-- Divider -->
                <hr class="w-px h-6 bg-slate-200" />

                <!-- User button -->
                <div class="relative inline-flex" x-data="{ open: false }">
                    <button class="inline-flex justify-center items-center group" aria-haspopup="true"
                        @click.prevent="open = !open" :aria-expanded="open">
                        <div class="mr-4">
                            <img class="w-19 h-13 rounded-full" src="{{ auth()->user()?->profile_picture }}"
                                width="32" height="32" alt="User upload" />
                        </div>
                        <div class="flex items-center truncate">
                            <span
                                class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">{{ auth()->user()->username ?? auth()->user()?->first_name }}</span>
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
                            <div class="font-medium text-slate-800">{{ auth()->user()?->fullName }}</div>
                            <div class="text-xs text-slate-500 italic">{{ auth()->user()?->roles()->first()->name }}
                            </div>
                        </div>
                        <ul>
                            <li>
                                <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                    href="{{ route('admin.profile') }}" @click="open = false" @focus="open = true"
                                    @focusout="open = false">Profile</a>
                            </li>

                            <li>
                                <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                    href="{{ route('admin.change.password') }}" @click="open = false"
                                    @focus="open = true" @focusout="open = false">Change Password</a>
                            </li>
                            <li>
                                <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                    href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('form-logout').submit();"
                                    @click="open = false" @focus="open = true" @focusout="open = false">Log Out</a>
                                <form id="form-logout" class="d-none" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
</header>
