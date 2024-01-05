<div class="sm:flex sm:justify-between sm:items-center mb-8">
    <div class="">
        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">{{ $pageTitle }}</h1>
    </div>
    @if (isset($html))
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a class="btn bg-indigo-500 hover:bg-indigo-600 text-white" href="{{ $html['route'] }}">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="hidden xs:block ml-2">{{ $html['text'] }}</span>
            </a>
        </div>
    @endif

    @if (isset($backbutton))
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2 ">
            <a class="btn bg-indigo-500 hover:bg-indigo-600 text-white" href="{{ url()->previous() }}">
                {{--  <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg> --}}
                <span class="hidden xs:block ml-2">Back</span>
            </a>
        </div>
    @endif
</div>
