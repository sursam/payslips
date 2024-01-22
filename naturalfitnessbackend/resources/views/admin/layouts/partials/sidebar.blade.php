<!-- BEGIN: Side Menu -->

<nav class="side-nav">
    <a href class="intro-x flex justify-center items-center pt-1">
        <img alt="Midone - HTML Admin Template" class="h-12" src="{{ asset('assets/images/full-logo.png') }}">
        {{-- <span class="text-white text-lg ml-3"> {{ __("Da'Ride") }} </span> --}}
    </a>
    <div class="side-nav__devider my-4"></div>
    <ul>
        @can('view-dashboard')
            <li>
                <a href="{{ route('admin.home') }}" class="side-menu {{ sidebarOpen(['admin.home']) }}">
                    <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                    <div class="side-menu__title">
                        Dashboard
                    </div>
                </a>
            </li>
        @endcan
        @canany(['add-user', 'view-user', 'edit-user', 'delete-user'])
            <li>
                <a href="javascript:;" class="side-menu {{ sidebarOpen(['admin.users.*']) }}">
                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="side-menu__title">
                        User Management
                        <div class="side-menu__sub-icon {{ dropdownarrowOpen(['admin.users.*']) }}"> <i
                                data-lucide="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class="{{ dropdownInnerOpen(['admin.users.*']) }}">
                    <li>
                        <a href="{{ route('admin.users.list', 'admin') }}"
                            class="side-menu {{ request()->userType == 'admin' ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="users"></i>
                            </div>
                            <div class="side-menu__title">
                                Admin Users </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.list', 'doctor') }}"
                            class="side-menu {{ request()->userType == 'doctor' ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="users"></i>
                            </div>
                            <div class="side-menu__title">
                                Doctors </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.list', 'patient') }}"
                            class="side-menu {{ request()->userType == 'patient' ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="users"></i>
                            </div>
                            <div class="side-menu__title">
                                Patients </div>
                        </a>
                    </li>
                </ul>
            </li>

        @endcanany
        {{--  @canany(['view-referral', 'delete-referral'])  --}}
            <li>
                <a href="javascript:;" class="side-menu {{ sidebarOpen(['admin.referral.*']) }}">
                    <div class="side-menu__icon "> <i data-lucide="users"></i> </div>
                    <div class="side-menu__title">
                        Referrals
                        <div class="side-menu__sub-icon {{ dropdownarrowOpen(['admin.referral.*']) }}"> <i
                            data-lucide="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class="{{ dropdownInnerOpen(['admin.referral.*']) }}">
                    <li>
                        <a href="{{ route('admin.referral.user.list') }}"
                            class="side-menu {{ sidebarOpen(['admin.referral.user.*']) }}">
                            <div class="side-menu__icon"> <i data-lucide="users"></i>
                            </div>
                            <div class="side-menu__title">
                                Referrals List </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.referral.type.list') }}"
                            class="side-menu {{ sidebarOpen(['admin.referral.type.*']) }}">
                            <div class="side-menu__icon"> <i data-lucide="book-open"></i>
                            </div>
                            <div class="side-menu__title">
                                Referral Types </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu {{ sidebarOpen(['admin.medical.*']) }}">
                    <div class="side-menu__icon "> <i data-lucide="activity"></i> </div>
                    <div class="side-menu__title">
                        Medical Management
                        <div class="side-menu__sub-icon {{ dropdownarrowOpen(['admin.medical.*']) }}"> <i
                            data-lucide="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class="{{ dropdownInnerOpen(['admin.medical.*']) }}">
                    <li>
                        <a href="{{ route('admin.medical.issue.list') }}"
                            class="side-menu {{ sidebarOpen(['admin.medical.issue.*']) }}">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i>
                            </div>
                            <div class="side-menu__title">
                                Issues List </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.medical.question.list') }}"
                            class="side-menu {{ sidebarOpen(['admin.medical.question.*']) }}">
                            <div class="side-menu__icon"> <i data-lucide="help-circle"></i>
                            </div>
                            <div class="side-menu__title">
                                Questionnarie </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.medical.doctor.level.list') }}"
                            class="side-menu {{ sidebarOpen(['admin.medical.doctor.level.*']) }}">
                            <div class="side-menu__icon"> <i data-lucide="ticket"></i>
                            </div>
                            <div class="side-menu__title">
                                {{ __("Doctor's Level") }} </div>
                        </a>
                    </li>
                </ul>
            </li>
        {{--  @endcanany  --}}
        @canany(['add-page', 'edit-page', 'view-page', 'delete-page'])
            <li>
                <a href="javascript:;" class="side-menu {{ sidebarOpen(['admin.cms.*']) }}">
                    <div class="side-menu__icon "> <i data-lucide="layout"></i> </div>
                    <div class="side-menu__title">
                        CMS
                        <div class="side-menu__sub-icon {{ dropdownarrowOpen(['admin.cms.*']) }}"> <i
                                data-lucide="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class="{{ dropdownInnerOpen(['admin.cms.*']) }}">
                    <li>
                        <a href="{{ route('admin.cms.page.list') }}"
                            class="side-menu {{ sidebarOpen(['admin.cms.page.*']) }}">
                            <div class="side-menu__icon"> <i data-lucide="book-open"></i>
                            </div>
                            <div class="side-menu__title">
                                Pages </div>
                        </a>
                    </li>

                </ul>
            </li>
        @endcanany
        <li>
            <a href="javascript:;" class="side-menu {{ sidebarOpen(['admin.booking.*']) }}">
                <div class="side-menu__icon "> <i data-lucide="ticket"></i> </div>
                <div class="side-menu__title">
                    Booking Management
                    <div class="side-menu__sub-icon {{ dropdownarrowOpen(['admin.booking.*']) }}"> <i
                            data-lucide="chevron-down"></i>
                    </div>
                </div>
            </a>
            <ul class="{{ dropdownInnerOpen(['admin.booking.*']) }}">
                <li>
                    <a href="{{ route('admin.booking.list') }}" class="side-menu {{ sidebarOpen(['admin.booking.list', 'admin.booking.add', 'admin.booking.edit']) }}">
                        <div class="side-menu__icon"> <i data-lucide="ticket"></i>
                        </div>
                        <div class="side-menu__title">
                            Manage Bookings </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.booking.doctor.availability.list') }}" class="side-menu {{ sidebarOpen(['admin.booking.doctor.availability.*']) }}">
                        <div class="side-menu__icon"> <i data-lucide="ticket"></i>
                        </div>
                        <div class="side-menu__title">
                            {{ __("Doctor's Availabilities") }} </div>
                    </a>
                </li>
            </ul>
        </li>


        {{--  <li>
            <a href="javascript:;" class="side-menu {{ sidebarOpen(['admin.support.queries.*', 'admin.support.faq.*']) }}">
                <div class="side-menu__icon "> <i data-lucide="help-circle"></i> </div>
                <div class="side-menu__title">
                    Queries & Help Desk
                    <div class="side-menu__sub-icon {{ dropdownarrowOpen(['admin.support.*']) }}"> <i
                            data-lucide="chevron-down"></i>
                    </div>
                </div>
            </a>
            <ul class="{{ dropdownInnerOpen(['admin.support.queries.*', 'admin.support.faq.*']) }}">
                <li>
                    <a href="{{ route('admin.support.queries.list') }}"
                        class="side-menu {{ sidebarOpen(['admin.support.queries.*']) }}">
                        <div class="side-menu__icon"> <i data-lucide="book-open"></i>
                        </div>
                        <div class="side-menu__title">
                            Quaries</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.support.faq.list') }}"
                        class="side-menu {{ sidebarOpen(['admin.support.faq.*']) }}">
                        <div class="side-menu__icon"> <i data-lucide="book-open"></i>
                        </div>
                        <div class="side-menu__title">
                            FAQ </div>
                    </a>
                </li>
            </ul>
        </li>  --}}

        <li>
            <a href="javascript:void(0)" class="side-menu {{ sidebarOpen(['admin.settings.*', 'admin.support.type.*']) }}">
                <div class="side-menu__icon"> <i data-lucide="settings"></i> </div>
                <div class="side-menu__title">
                    Settings
                    <div class="side-menu__sub-icon {{ dropdownarrowOpen(['admin.settings.*']) }}"> <i
                            data-lucide="chevron-down"></i>
                    </div>
                </div>
            </a>
            <ul class="{{ dropdownInnerOpen(['admin.settings.*']) }}">
                @role('super-admin')
                    <li>
                        <a href="{{ route('admin.settings.site.setting') }}"
                            class="side-menu {{ sidebarOpen(['admin.settings.site.*']) }}">
                            <div class="side-menu__icon"> <i data-lucide="settings"></i>
                            </div>
                            <div class="side-menu__title">
                                Settings</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.role.list') }}"
                            class="side-menu {{ sidebarOpen(['admin.settings.role.*']) }}">
                            <div class="side-menu__icon"> <i data-lucide="lock"></i>
                            </div>
                            <div class="side-menu__title">
                                Roles & Permissions</div>
                        </a>
                    </li>
                @endrole
            </ul>
        </li>

    </ul>
</nav>
<!-- END: Side Menu -->
