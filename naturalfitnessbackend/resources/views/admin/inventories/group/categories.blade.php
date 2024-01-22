@extends('admin.layouts.app', ['isNavbar' => true, 'isSidebar' => true, 'isFooter' => true])

@push('styles')
@endpush

@section('content')
    @php
        $categoryCollection = collect($group->categories->pluck('uuid'));
    @endphp
    {{-- @dd($categoryCollection) --}}
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex">
                    <h1 class="col-6 m-0">Attach Categories</h1>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.inventories.group.list') }}" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-3">
                            <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post"
                                action="{{ route('admin.inventories.group.attach.categories', $group->uuid) }}"
                                id="categorysubmit">
                                @csrf
                                <div class="d-flex">
                                    @forelse ($categories as $chunk)
                                        @if ($loop->count < 2)
                                            @php
                                                $class = 'col-lg-12';
                                            @endphp
                                        @elseif ($loop->count < 3)
                                            @php
                                                $class = 'col-lg-6';
                                            @endphp
                                        @elseif ($loop->count < 4)
                                            @php
                                                $class = 'col-lg-4';
                                            @endphp
                                        @else
                                            @php
                                                $class = 'col-lg-3';
                                            @endphp
                                        @endif
                                        <div class="card shadow mb-4 {{ $class }}">
                                            @forelse ($chunk as $category)
                                                <div class="text-justify mt-2">
                                                    <div class="text-sm">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" class="form-checkbox" name="categories[]"
                                                                value="{{ $category->uuid }}"
                                                                @checked($categoryCollection->contains($category->uuid)) />
                                                            <span class="text-sm ml-2">
                                                                {{ $category->parent ? $category->parent->name . '->' : ' ' }}
                                                            </span>
                                                            <span class="text-sm ml-2">{{ $category->name }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    @empty
                                    @endforelse
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Attach Categories
                                </button>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
