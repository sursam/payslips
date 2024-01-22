@extends('admin.layouts.app', ['isNavbar' => true, 'isSidebar' => true, 'isFooter' => true])

@push('styles')
@endpush

@section('content')

    @php
        $attributesCollection = collect($category->attributes->pluck('uuid'));
    @endphp
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex">
                    <h1 class="col-6 m-0">Attach Attributes</h1>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.inventories.categories.list') }}" class="btn btn-warning btn-icon-split">
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
                                action="{{ route('admin.inventories.categories.attach.attributes', $category->uuid) }}"
                                id="categorysubmit">
                                @csrf
                                <div class="d-flex">
                                    @forelse ($attributes as $chunk)
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
                                            @forelse ($chunk as $attribute)
                                                <div class="text-justify mt-2">
                                                    <div class="text-sm">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" class="form-checkbox" name="attributes[]"
                                                                value="{{ $attribute->uuid }}"
                                                                @checked($attributesCollection->contains($attribute->uuid)) />
                                                            <span class="text-sm ml-2">{{ $attribute->name }}</span>
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
