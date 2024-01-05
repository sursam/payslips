@extends('admin.layouts.app')
@push('style')
    <style type="text/css">
        .filter-tab li button.active {
            color: #0d6efd;
        }
    </style>
@endpush
@section('content')
    <div>
        <div class="border-t border-slate-200">
            <div>
                <h2 class="text-2xl text-slate-800 font-bold mb-6">{{ $pageTitle }}</h2>
                <!-- Start -->
                <div class="mb-8 border-b border-slate-200">
                    <ul class="nav nav-tabs text-sm font-medium flex flex-nowrap -mx-4 sm:-mx-6 lg:-mx-8 overflow-x-scroll no-scrollbar filter-tab"
                        role="tablist">
                        <li
                            class=" nav-item pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                            <button class="text-slate-500 hover:text-slate-600 whitespace-nowrap flex items-center active"
                                type="button" data-bs-toggle="tab" data-bs-target="#all-orders" role="tab"
                                aria-controls="all-orders" aria-selected="true">
                                <svg class="w-4 h-4 shrink-0 fill-current mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M12.311 9.527c-1.161-.393-1.85-.825-2.143-1.175A3.991 3.991 0 0012 5V4c0-2.206-1.794-4-4-4S4 1.794 4 4v1c0 1.406.732 2.639 1.832 3.352-.292.35-.981.782-2.142 1.175A3.942 3.942 0 001 13.26V16h14v-2.74c0-1.69-1.081-3.19-2.689-3.733zM6 4c0-1.103.897-2 2-2s2 .897 2 2v1c0 1.103-.897 2-2 2s-2-.897-2-2V4zm7 10H3v-.74c0-.831.534-1.569 1.33-1.838 1.845-.624 3-1.436 3.452-2.422h.436c.452.986 1.607 1.798 3.453 2.422A1.943 1.943 0 0113 13.26V14z" />
                                </svg>
                                <span>General</span>
                            </button>
                        </li>
                        <li
                            class="nav-item pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                            <button class="text-slate-500 hover:text-slate-600 whitespace-nowrap flex items-center"
                                type="button" data-bs-toggle="tab" data-bs-target="#currency" role="tab"
                                aria-controls="currency" aria-selected="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 mr-2" viewBox=" 0 0 36 36">
                                    <path
                                        d="M14.86 0a.52.52 0 0 0-.5.5v4.047a14 14 0 0 0-3.329 1.367l-2.84-2.838a.52.52 0 0 0-.707 0L3.04 7.521a.52.52 0 0 0 0 .708l2.84 2.84a13.996 13.996 0 0 0-1.367 3.292H.5a.52.52 0 0 0-.5.5v6.315c0 .262.238.5.5.5h4.012a13.996 13.996 0 0 0 1.367 3.293l-2.84 2.84a.52.52 0 0 0 0 .707l4.445 4.445a.52.52 0 0 0 .707 0l2.84-2.838a14.004 14.004 0 0 0 3.328 1.367v4.01c0 .262.239.5.5.5h6.282a.52.52 0 0 0 .5-.5v-4.014a14.006 14.006 0 0 0 3.293-1.363l2.837 2.838a.52.52 0 0 0 .71 0l4.445-4.445a.52.52 0 0 0 0-.707l-2.84-2.84a13.996 13.996 0 0 0 1.367-3.293H35.5a.52.52 0 0 0 .5-.5V14.86a.52.52 0 0 0-.5-.5h-4.047a13.996 13.996 0 0 0-1.367-3.293l2.84-2.84a.52.52 0 0 0 0-.707L28.48 3.076a.52.52 0 0 0-.709 0l-2.837 2.838A14.007 14.007 0 0 0 21.64 4.55V.5a.52.52 0 0 0-.5-.5zm.5 1h5.28v3.875c0 .222.167.434.383.486 1.332.32 2.605.849 3.772 1.565.19.116.458.084.615-.074l2.715-2.715 3.74 3.738-2.717 2.715a.515.515 0 0 0-.072.615 13.026 13.026 0 0 1 1.563 3.772.515.515 0 0 0 .486.384H35v5.315h-3.875a.515.515 0 0 0-.486.385 13.026 13.026 0 0 1-1.563 3.771.515.515 0 0 0 .072.613l2.717 2.717-3.738 3.738-2.717-2.716a.515.515 0 0 0-.615-.073 13.031 13.031 0 0 1-3.772 1.565.515.515 0 0 0-.382.486V35h-5.282v-3.838a.516.516 0 0 0-.384-.488 13.033 13.033 0 0 1-3.807-1.563.515.515 0 0 0-.613.073L7.838 31.9 4.1 28.162l2.716-2.717a.515.515 0 0 0 .073-.613 13.026 13.026 0 0 1-1.563-3.771.515.515 0 0 0-.486-.385H1V15.36h3.84a.515.515 0 0 0 .486-.384c.32-1.332.847-2.605 1.563-3.772a.515.515 0 0 0-.073-.615L4.1 7.875l3.738-3.738 2.717 2.715c.157.157.423.189.613.074a13.033 13.033 0 0 1 3.807-1.563.516.516 0 0 0 .384-.488zM18 8.787c-5.088 0-9.25 4.123-9.25 9.213 0 5.09 4.16 9.25 9.25 9.25s9.215-4.162 9.215-9.25S23.088 8.787 18 8.787zm0 1A8.198 8.198 0 0 1 26.215 18c0 4.549-3.669 8.25-8.215 8.25-4.546 0-8.25-3.704-8.25-8.25 0-4.546 3.701-8.213 8.25-8.213zm-.02.713c-4.143 0-7.48 3.37-7.48 7.5 0 4.132 3.337 7.5 7.48 7.5 4.143 0 7.52-3.364 7.52-7.5a.502.502 0 0 0-.041-.195c-.112-4.038-3.407-7.303-7.479-7.303zm0 1c3.603 0 6.52 2.91 6.52 6.5 0 3.592-2.917 6.5-6.52 6.5A6.47 6.47 0 0 1 11.5 18c0-3.594 2.877-6.5 6.48-6.5zm.012 2.002a.52.52 0 0 0-.492.506v.54c-.964.211-1.748.91-1.748 1.893 0 1.134.991 2.005 2.16 2.047a.49.49 0 0 0 .082.008l.006.002c.73 0 1.248.496 1.248 1.055 0 .559-.518 1.053-1.248 1.053s-1.248-.494-1.248-1.053a.52.52 0 0 0-.5-.507.52.52 0 0 0-.5.507c0 .997.768 1.79 1.748 1.996v.445a.52.52 0 0 0 .5.507.52.52 0 0 0 .5-.507v-.549c.964-.21 1.748-.907 1.748-1.89 0-1.657-1.23-2.059-2.242-2.059H18c-.73 0-1.248-.496-1.248-1.055 0-.549.503-1.03 1.213-1.046a.51.51 0 0 0 .074 0c.708.018 1.209.498 1.209 1.046a.52.52 0 0 0 .5.508.52.52 0 0 0 .5-.508c0-.983-.784-1.684-1.748-1.894v-.54a.52.52 0 0 0-.508-.505z"
                                        color="#000" font-family="sans-serif" font-weight="400" overflow="visible" />
                                </svg>
                                <span>Currency</span>
                            </button>
                        </li>
                        <li
                            class="nav-item pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                            <button class="text-slate-500 hover:text-slate-600 whitespace-nowrap flex items-center"
                                type="button" data-bs-toggle="tab" data-bs-target="#robots" role="tab"
                                aria-controls="robots" aria-selected="true">

                                <svg xmlns="http://www.w3.org/2000/svg" data-name="Artboard 30" viewbox="0 0 60 60"
                                    class="w-4 h-4 shrink-0 mr-2">
                                    <path
                                        d="M37,11H29a1,1,0,0,0-1,1,5,5,0,0,0,10,0A1,1,0,0,0,37,11Zm-4,4a3.006,3.006,0,0,1-2.829-2h5.658A3.006,3.006,0,0,1,33,15Z" />
                                    <path
                                        d="M6.105,7.553A1,1,0,0,0,6,8v3a1,1,0,0,0-1,1v4a1,1,0,0,0,1,1H7v5a7.008,7.008,0,0,0,7,7h7V42a3,3,0,0,0,1.869,2.775L21.093,56.316A6.006,6.006,0,0,0,17,62a1,1,0,0,0,1,1H28a1,1,0,0,0,1-1V57.076L30.858,45h4.284L37,57.076V62a1,1,0,0,0,1,1H48a1,1,0,0,0,1-1,6.006,6.006,0,0,0-4.093-5.684L43.131,44.775A3,3,0,0,0,45,42V28h4a1,1,0,0,1,1,1v4H49a1,1,0,0,0-1,1v4a1,1,0,0,0,1,1v3a1,1,0,0,0,.1.447l1,2,1.79-.894L51,41.764V39h5v2.764l-.9,1.789,1.79.894,1-2A1,1,0,0,0,58,42V39a1,1,0,0,0,1-1V34a1,1,0,0,0-1-1H57V28a7.008,7.008,0,0,0-7-7H44.816A3,3,0,0,0,44,19.78V17h1a3,3,0,0,0,3-3V10a3,3,0,0,0-3-3H43.075A11.094,11.094,0,0,0,33,1,11.094,11.094,0,0,0,22.925,7H21a3,3,0,0,0-3,3v4a3,3,0,0,0,3,3h1v2.78A2.985,2.985,0,0,0,21,22H15a1,1,0,0,1-1-1V17h1a1,1,0,0,0,1-1V12a1,1,0,0,0-1-1V8a1,1,0,0,0-.105-.447l-1-2-1.79.894L13,8.236V11H8V8.236L8.9,6.447l-1.79-.894ZM9,22h3.184a3.005,3.005,0,0,0,.58.981L10.7,25.729A4.966,4.966,0,0,1,9,22Zm15-1h4v3a1,1,0,0,0,1,1h8a1,1,0,0,0,1-1V21h4a1,1,0,0,1,1,1V39H41V28a1,1,0,0,0-1-1H27a1,1,0,0,0-1,1V39H23V22A1,1,0,0,1,24,21Zm6,0h6v2H30ZM42,43H24a1,1,0,0,1-1-1V41H43v1A1,1,0,0,1,42,43ZM39,31H28V29H39ZM28,33H39v2H28Zm0,4H39v2H28Zm-.858,19H23.165l.462-3H27.6Zm.769-5H23.935l.307-2h3.977ZM27,61H19.126A4.008,4.008,0,0,1,23,58h4Zm1.527-14H24.55l.308-2h3.976Zm12.615-2,.308,2H37.473l-.307-2ZM38.4,53h3.977l.462,3H38.858Zm-.307-2-.308-2h3.977l.307,2Zm8.785,10H39V58h4A4.008,4.008,0,0,1,46.874,61ZM45,26V23h4v3Zm5,9h7v2H50Zm2-2V30h3v3Zm3-5H51.816A3,3,0,0,0,51,26.78V23.1A5.009,5.009,0,0,1,55,28ZM45,9a1,1,0,0,1,1,1v4a1,1,0,0,1-1,1H44V11a9.122,9.122,0,0,0-.222-2ZM21,15a1,1,0,0,1-1-1V10a1,1,0,0,1,1-1h1.222A9.122,9.122,0,0,0,22,11v4Zm3-4c0-4.411,4.038-8,9-8s9,3.589,9,8v8H24ZM21,27H18V24h3Zm-5-3v3H14a4.943,4.943,0,0,1-1.548-.27l2.083-2.777A2.979,2.979,0,0,0,15,24Zm-4-4H9V17h3Zm2-5H7V13h7Z" />
                                </svg>
                                <span>Robots</span>
                            </button>
                        </li>
                        <li
                            class="nav-item pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                            <button class="text-slate-500 hover:text-slate-600 whitespace-nowrap flex items-center"
                                type="button" data-bs-toggle="tab" data-bs-target="#analytics" role="tab"
                                aria-controls="analytics" aria-selected="true">

                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 26 26" class="w-4 h-4 shrink-0 mr-2">
                                    <path
                                        d="M29.432 32h-26.905c-1.391 0-2.527-1.136-2.527-2.527v-5.895c0-1.391 1.136-2.527 2.527-2.527h7.577v-8.421c0-1.385 1.141-2.527 2.527-2.527h8.443v-7.536c0-1.407 1.161-2.568 2.567-2.568h5.792c1.407 0 2.568 1.161 2.568 2.568v26.864c0 1.407-1.161 2.568-2.568 2.568z" />
                                </svg>
                                <span>Analytics</span>
                            </button>
                        </li>
                        <li
                            class="nav-item pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                            <button class="text-slate-500 hover:text-slate-600 whitespace-nowrap flex items-center"
                                type="button" data-bs-toggle="tab" data-bs-target="#socials" role="tab"
                                aria-controls="socials" aria-selected="true">

                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="5 5 45 45" class="w-4 h-4 shrink-0 mr-2">
                                    <path fill="#039be5" d="M24 5A19 19 0 1 0 24 43A19 19 0 1 0 24 5Z" />
                                    <path fill="#fff"
                                        d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z" />
                                </svg>
                                <span>Socials</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active container" id="all-orders" role="tabpanel"
                        aria-labelledby="all-orders-tab">
                        @include('admin.setting.includes.general')
                    </div>

                    <div class="tab-pane fade container" id="currency" role="tabpanel" aria-labelledby="currency-tab">
                        @include('admin.setting.includes.currency')
                    </div>

                    <div class="tab-pane fade container" id="robots" role="tabpanel" aria-labelledby="robots-tab">
                        @include('admin.setting.includes.robots')
                    </div>
                    <div class="tab-pane fade container" id="analytics" role="tabpanel" aria-labelledby="analytics-tab">
                        @include('admin.setting.includes.analytics')
                    </div>
                    <div class="tab-pane fade container" id="socials" role="tabpanel" aria-labelledby="socials-tab">
                        @include('admin.setting.includes.social_links')
                    </div>
                </div>
                <!-- End -->
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/admin/js/settings.js') }}"></script>
@endpush
