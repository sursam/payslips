  <!-- Sidebar backdrop (mobile only) -->
  <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak>
</div>
  <!-- Sidebar -->
<div id="sidebar" class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false" @keydown.escape.window="sidebarOpen = false" x-cloak="lg">
    <!-- Sidebar header -->
    <div class="flex justify-between mb-10 pr-3 sm:px-2">
        <!-- Close button -->
        <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen"
            aria-controls="sidebar" :aria-expanded="sidebarOpen">
            <span class="sr-only">Close sidebar</span>
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
            </svg>
        </button>
        <!-- Logo -->
        <a class="block" href="index.html">
            <!--<svg width="32" height="32" viewBox="0 0 32 32">
                        <defs>
                            <linearGradient x1="28.538%" y1="20.229%" x2="100%" y2="108.156%" id="logo-a">
                                <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%" />
                                <stop stop-color="#A5B4FC" offset="100%" />
                            </linearGradient>
                            <linearGradient x1="88.638%" y1="29.267%" x2="22.42%" y2="100%" id="logo-b">
                                <stop stop-color="#38BDF8" stop-opacity="0" offset="0%" />
                                <stop stop-color="#38BDF8" offset="100%" />
                            </linearGradient>
                        </defs>
                        <rect fill="#6366F1" width="32" height="32" rx="16" />
                        <path d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z" fill="#4F46E5" />
                        <path d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z" fill="url(#logo-a)" />
                        <path d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z" fill="url(#logo-b)" />
                    </svg>-->
            <img src="{{ asset('assets/admin/images/logo.png') }}" alt="Canably" />
        </a>
    </div>

    <!-- Links -->
    <div class="space-y-8">
        <!-- Pages group -->
        <div>
            <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                    aria-hidden="true">•••</span>
                <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">E-Commerce</span>
            </h3>
            <ul class="mt-3">
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                        href="dashboard.html">
                        <div class="flex items-center">
                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                <path class="fill-current text-indigo-500"
                                    d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z" />
                                <path class="fill-current text-indigo-600"
                                    d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z" />
                                <path class="fill-current text-indigo-200"
                                    d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z" />
                            </svg>
                            <span
                                class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                        </div>
                    </a>
                </li>
                <!-- Dashboard -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                        href="inbox.html">
                        <div class="flex items-center">
                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                <path class="fill-current text-slate-600"
                                    d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                <path class="fill-current text-slate-400"
                                    d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                            </svg>
                            <span
                                class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                Customers</span>
                        </div>
                    </a>
                </li>

                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                        href="inbox.html">
                        <div class="flex items-center">
                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                <path class="fill-current text-slate-600"
                                    d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                <path class="fill-current text-slate-400"
                                    d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                            </svg>
                            <span
                                class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                Sellers</span>
                        </div>
                    </a>
                </li>

                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                        href="inbox.html">
                        <div class="flex items-center">
                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                <path class="fill-current text-slate-600"
                                    d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                <path class="fill-current text-slate-400"
                                    d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                            </svg>
                            <span
                                class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                Delivery Agents</span>
                        </div>
                    </a>
                </li>

                <!-- E-Commerce -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" x-data="{ open: false }">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="#0"
                        @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path class="fill-current text-slate-400"
                                        d="M13 15l11-7L11.504.136a1 1 0 00-1.019.007L0 7l13 8z" />
                                    <path class="fill-current text-slate-700"
                                        d="M13 15L0 7v9c0 .355.189.685.496.864L13 24v-9z" />
                                    <path class="fill-current text-slate-600"
                                        d="M13 15.047V24l10.573-7.181A.999.999 0 0024 16V8l-11 7.047z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Product
                                    Catalog</span>
                            </div>
                            <!-- Icon -->
                            <div
                                class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                        <ul class="pl-9 mt-1 hidden" :class="open ? '!block' : 'hidden'">
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="customers.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                        Categories</span>
                                </a>
                            </li>
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="orders.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                        Attributes</span>
                                </a>
                            </li>
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="invoices.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                        Products</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <!-- Product Inventory -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" x-data="{ open: false }">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="#0"
                        @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path class="fill-current text-slate-600"
                                        d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                    <path class="fill-current text-slate-400"
                                        d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Product
                                    Inventory</span>
                            </div>
                            <!-- Icon -->
                            <div
                                class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                        <ul class="pl-9 mt-1 hidden" :class="open ? '!block' : 'hidden'">
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="users-tabs.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Product
                                        Stock</span>
                                </a>
                            </li>
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="users-tiles.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Stock
                                        Count</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <!-- Orders -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                        href="inbox.html">
                        <div class="flex items-center">
                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                <path class="fill-current text-slate-600" d="M16 13v4H8v-4H0l3-9h18l3 9h-8Z" />
                                <path class="fill-current text-slate-400"
                                    d="m23.72 12 .229.686A.984.984 0 0 1 24 13v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-8c0-.107.017-.213.051-.314L.28 12H8v4h8v-4H23.72ZM13 0v7h3l-4 5-4-5h3V0h2Z" />
                            </svg>
                            <span
                                class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                Orders</span>
                        </div>
                    </a>
                </li>
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                        href="inbox.html">
                        <div class="flex items-center">
                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                <path class="fill-current text-slate-600" d="M16 13v4H8v-4H0l3-9h18l3 9h-8Z" />
                                <path class="fill-current text-slate-400"
                                    d="m23.72 12 .229.686A.984.984 0 0 1 24 13v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-8c0-.107.017-.213.051-.314L.28 12H8v4h8v-4H23.72ZM13 0v7h3l-4 5-4-5h3V0h2Z" />
                            </svg>
                            <span
                                class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                Deliveries</span>
                        </div>
                    </a>
                </li>
                <!-- Finance -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" x-data="{ open: false }">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="#0"
                        @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path class="fill-current text-slate-400"
                                        d="M13 6.068a6.035 6.035 0 0 1 4.932 4.933H24c-.486-5.846-5.154-10.515-11-11v6.067Z" />
                                    <path class="fill-current text-slate-700"
                                        d="M18.007 13c-.474 2.833-2.919 5-5.864 5a5.888 5.888 0 0 1-3.694-1.304L4 20.731C6.131 22.752 8.992 24 12.143 24c6.232 0 11.35-4.851 11.857-11h-5.993Z" />
                                    <path class="fill-current text-slate-600"
                                        d="M6.939 15.007A5.861 5.861 0 0 1 6 11.829c0-2.937 2.167-5.376 5-5.85V0C4.85.507 0 5.614 0 11.83c0 2.695.922 5.174 2.456 7.17l4.483-3.993Z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Finance</span>
                            </div>
                            <!-- Icon -->
                            <div
                                class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                        <ul class="pl-9 mt-1 hidden" :class="open ? '!block' : 'hidden'">
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="credit-cards.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">View
                                        Transactions</span>
                                </a>
                            </li>
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="transactions.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Invoices</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                        href="inbox.html">
                        <div class="flex items-center">
                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                <path class="fill-current text-slate-600" d="M16 13v4H8v-4H0l3-9h18l3 9h-8Z" />
                                <path class="fill-current text-slate-400"
                                    d="m23.72 12 .229.686A.984.984 0 0 1 24 13v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-8c0-.107.017-.213.051-.314L.28 12H8v4h8v-4H23.72ZM13 0v7h3l-4 5-4-5h3V0h2Z" />
                            </svg>
                            <span
                                class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Coupons
                                and Offers</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- More group -->
        <div>
            <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                    aria-hidden="true">•••</span>
                <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Content Management</span>
            </h3>
            <ul class="mt-3">
                <!-- Manage Users -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" x-data="{ open: false }">
                    <a class="block text-slate-200 hover:text-white transition duration-150"
                        :class="open && 'hover:text-slate-200'" href="#0"
                        @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path class="fill-current text-slate-600" d="M8.07 16H10V8H8.07a8 8 0 110 8z" />
                                    <path class="fill-current text-slate-400" d="M15 12L8 6v5H0v2h8v5z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">CMS</span>
                            </div>
                            <!-- Icon -->
                            <div
                                class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                        <ul class="pl-9 mt-1 hidden" :class="open ? '!block' : 'hidden'">
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="signin.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                        Pages</span>
                                </a>
                            </li>
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="signup.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                        Banners</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

            </ul>
        </div>

        <div>
            <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                    aria-hidden="true">•••</span>
                <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Administration</span>
            </h3>
            <ul class="mt-3">
                <!-- Manage Users -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" x-data="{ open: false }">
                    <a class="block text-slate-200 hover:text-white transition duration-150"
                        :class="open && 'hover:text-slate-200'" href="#0"
                        @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path class="fill-current text-slate-600" d="M8.07 16H10V8H8.07a8 8 0 110 8z" />
                                    <path class="fill-current text-slate-400" d="M15 12L8 6v5H0v2h8v5z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Admin
                                    Users</span>
                            </div>
                            <!-- Icon -->
                            <div
                                class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                        <ul class="pl-9 mt-1 hidden" :class="open ? '!block' : 'hidden'">
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="{{ url('admin/admin-roles') }}">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                        Admin Roles</span>
                                </a>
                            </li>
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="{{ url('admin/admin-user') }}">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manage
                                        Admin Users</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Settings -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" x-data="{ open: false }">
                    <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="#0"
                        @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path class="fill-current text-slate-600"
                                        d="M19.714 14.7l-7.007 7.007-1.414-1.414 7.007-7.007c-.195-.4-.298-.84-.3-1.286a3 3 0 113 3 2.969 2.969 0 01-1.286-.3z" />
                                    <path class="fill-current text-slate-400"
                                        d="M10.714 18.3c.4-.195.84-.298 1.286-.3a3 3 0 11-3 3c.002-.446.105-.885.3-1.286l-6.007-6.007 1.414-1.414 6.007 6.007z" />
                                    <path class="fill-current text-slate-600"
                                        d="M5.7 10.714c.195.4.298.84.3 1.286a3 3 0 11-3-3c.446.002.885.105 1.286.3l7.007-7.007 1.414 1.414L5.7 10.714z" />
                                    <path class="fill-current text-slate-400"
                                        d="M19.707 9.292a3.012 3.012 0 00-1.415 1.415L13.286 5.7c-.4.195-.84.298-1.286.3a3 3 0 113-3 2.969 2.969 0 01-.3 1.286l5.007 5.006z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Settings</span>
                            </div>
                            <!-- Icon -->
                            <div
                                class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                    :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                        <ul class="pl-9 mt-1 hidden" :class="open ? '!block' : 'hidden'">
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="settings.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">My
                                        Account</span>
                                </a>
                            </li>
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="notifications.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Notifications</span>
                                </a>
                            </li>
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="connected-apps.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Email
                                        Temlpates</span>
                                </a>
                            </li>
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="plans.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">General
                                        Settings</span>
                                </a>
                            </li>
                            <li class="mb-1 last:mb-0">
                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                    href="billing.html">
                                    <span
                                        class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Payment
                                        Settings</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
    <!-- Expand / collapse button -->
    <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
        <div class="px-3 py-2">
            <button @click="sidebarExpanded = !sidebarExpanded">
                <span class="sr-only">Expand / collapse sidebar</span>
                <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                    <path class="text-slate-400"
                        d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                    <path class="text-slate-600" d="M3 23H1V1h2z" />
                </svg>
            </button>
        </div>
    </div>

</div>
