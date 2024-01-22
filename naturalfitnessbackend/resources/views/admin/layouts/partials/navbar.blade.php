<!-- BEGIN: Top Bar -->
<div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Natural Fitness</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
        </ol>
    </nav>
    <!-- END: Breadcrumb -->
    <!-- BEGIN: Search -->
    <div class="intro-x relative mr-3 sm:mr-6">

    </div>
    <!-- END: Search -->
    <!-- BEGIN: Notifications -->
    <div class="intro-x dropdown mr-auto sm:mr-6">

    </div>
    <!-- END: Notifications -->
    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button"
            aria-expanded="false" data-tw-toggle="dropdown">
            <img alt="Midone - HTML Admin Template" src="{{ asset('assets/images/profile-15.jpg') }}">
        </div>
        <div class="dropdown-menu w-56">
            <ul class="dropdown-content bg-primary text-white">
                <li class="p-2">
                    <div class="font-medium">{{ auth()->user()->full_name }}</div>
                    {{--  <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">Backend
                        Engineer</div>  --}}
                </li>
                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
                <li>
                    <a href="{{ route('admin.profile') }}" class="dropdown-item hover:bg-white/5">
                        <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                        Profile </a>
                </li>
                {{--  <li>
                    <a href class="dropdown-item hover:bg-white/5">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        Add Account </a>
                </li>  --}}
                <li>
                    <a href="{{ route('admin.change.password') }}" class="dropdown-item hover:bg-white/5">
                        <i data-lucide="lock" class="w-4 h-4 mr-2"></i>
                        Change Password </a>
                </li>
                {{--  <li>
                    <a href class="dropdown-item hover:bg-white/5">
                        <i data-lucide="help-circle" class="w-4 h-4 mr-2"></i>
                        Help </a>
                </li>  --}}
                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
                <li>
                    <a class="dropdown-item hover:bg-white/5" href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('form-logout').submit();"><i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i>
                        Logout </a>
                    <form id="form-logout" class="d-none" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Account Menu -->
</div>
<!-- END: Top Bar -->
