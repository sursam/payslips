<div class="text-sm text-slate-500 italic mb-4">
    <h2 class="font-semibold text-slate-800">All Products <span
            class="text-slate-400 font-medium">({{ $products->count() }})</span>
    </h2>
</div>
<div>
    <div class="grid grid-cols-12 gap-2">
        @forelse ($products as $product)
            <div
                class="col-span-full md:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200 overflow-hidden customdatatable">
                <div class="flex flex-col h-full">
                    <!-- Image -->
                    <div class="relative">

                        <a title="View" href="{{ route('admin.catalog.product.view.gallery', $product->uuid) }}"><img
                                class="w-full" src="{{ $product->latest_image }}" width="301" height="226"
                                alt="Application 21" /></a>
                        <!-- Like button -->

                        <!-- Special Offer label -->
                        <div class="absolute bottom-0 right-0 mb-4 mr-4">
                            <div class="inline-flex items-center text-xs font-medium text-slate-100 bg-slate-900 bg-opacity-60 rounded-full text-center px-2 py-0.5"
                                style="{{ $product->discount ? 'display: show;' : 'display: none;' }}">
                                <svg class="w-3 h-3 shrink-0 fill-current text-amber-500 mr-1" viewBox="0 0 12 12">
                                    <path
                                        d="M11.953 4.29a.5.5 0 00-.454-.292H6.14L6.984.62A.5.5 0 006.12.173l-6 7a.5.5 0 00.379.825h5.359l-.844 3.38a.5.5 0 00.864.445l6-7a.5.5 0 00.075-.534z" />
                                </svg>
                                <span>{{ $product->discount ? 'Special Discount' : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Card Content -->
                    <div class="grow flex flex-col p-3">
                        <!-- Card body -->
                        <div class="grow">
                            <header class="mb-2">
                                <a href="{{ route('admin.catalog.product.view.gallery', $product->uuid) }}"
                                    title="View">
                                    <h3 class="text-lg text-slate-800 font-semibold mb-1">{{ $product->name }}</h3>
                                </a>
                                <p>Category : <span
                                        class="text-sm text-slate-800 font-semibold mb-1">{{ $product->category ? $product->category->name : '--' }}</span>
                                </p>

                            </header>
                        </div>

                        <!-- Rating and price -->
                        <div class="flex flex-wrap justify-between items-center">
                            <!-- Rating -->
                            <div class="flex items-center space-x-2 mr-2">
                                <div class="flex space-x-1 profile-rating">
                                    <div class="show-rating-list profile-rating--list">
                                        @php($filledWidth = ($product->average_rating / 5) * 100)
                                        <div class="rating_area">
                                            <div class="gray_rating"></div>
                                            <div class="filled_rating" style="width: {{ $filledWidth }}%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Rate -->
                                <div class="inline-flex text-sm font-medium text-amber-600">
                                    {{ $product->average_rating > 0 ? $product->average_rating : 'No Rating yet' }}</div>
                            </div><br><br>
                            <!-- Price -->
                            <div>
                                <div
                                    class="inline-flex text-sm font-medium bg-rose-100 text-rose-600 rounded-full text-center px-2 py-0.5">
                                    ${{ $product->price ? number_format($product->price, 2) : '0.00' }}</div>
                            </div>
                            <div class="flex items-center text-center">
                                <div class="m-1">
                                    <!-- Start -->
                                    @switch($product->is_active)
                                        @case(1)
                                            <a href="javascript:void(0)" data-value="0" data-table="products"
                                                data-message="inactive" data-uuid="{{ $product->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5 changeStatus">Active</a>
                                        @break

                                        @case(0)
                                            <a href="javascript:void(0)" data-value="1" data-table="products"
                                                data-message="active" data-uuid="{{ $product->uuid }}"
                                                class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5 changeStatus">Inactive</a>
                                        @break

                                        @default
                                            <a href="javascript:void(0)"
                                                class="inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-0.5">Deleted</a>
                                    @endswitch
                                </div>
                                <div class="m-1">
                                    <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                        href="{{ route('admin.catalog.product.edit', $product->uuid) }}">
                                        <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="m-1">
                                    <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-rose-500 deleteData"
                                        data-table="products" data-uuid="{{ $product->uuid }}"
                                        href="javascript:void(0)">
                                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                                        </svg>

                                    </a>
                                </div>
                                <div class="m-2">
                                    <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-rose-500 viewImages"
                                        data-uuid="{{ $product->uuid }}"
                                        href="javascript:void(0)">
                                        <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill-rule="evenodd" clip-rule="evenodd">
                                            <path fill-rule="nonzero"
                                                d="M7.6 0h496.8c4.2 0 7.6 3.27 7.6 7.29v406.36c0 4.02-3.4 7.29-7.6 7.29H7.6c-4.2 0-7.6-3.27-7.6-7.29V7.29C0 3.27 3.4 0 7.6 0zm187.57 109.29c4.71 0 9.15.87 13.29 2.58 4.19 1.73 7.95 4.27 11.26 7.58 3.29 3.29 5.8 6.98 7.51 11.05 1.72 4.07 2.57 8.44 2.57 13.07 0 4.75-.85 9.2-2.56 13.35-1.71 4.16-4.22 7.89-7.52 11.2l-.45.41c-3.21 3.15-6.81 5.53-10.76 7.17-4.16 1.72-8.61 2.58-13.34 2.58-4.74 0-9.21-.86-13.38-2.57-4.14-1.7-7.88-4.24-11.22-7.61-3.32-3.29-5.83-7.02-7.54-11.18-1.7-4.15-2.56-8.6-2.56-13.35 0-4.61.86-8.97 2.57-13.04 1.7-4.07 4.21-7.78 7.52-11.08 3.31-3.31 7.07-5.85 11.27-7.58 4.15-1.71 8.6-2.58 13.34-2.58zm7.53 16.59c-2.23-.93-4.75-1.4-7.53-1.4-2.81 0-5.34.47-7.58 1.39-2.24.93-4.34 2.37-6.29 4.32-1.93 1.93-3.35 3.99-4.26 6.16-.91 2.18-1.37 4.59-1.37 7.22 0 2.84.46 5.37 1.37 7.59.91 2.21 2.33 4.28 4.26 6.22l.03.06c1.89 1.91 3.97 3.34 6.22 4.26 2.24.92 4.78 1.38 7.62 1.38 2.81 0 5.34-.46 7.58-1.39 2.1-.86 4.05-2.17 5.84-3.91l.38-.4c1.94-1.94 3.36-4.01 4.27-6.22.91-2.22 1.37-4.75 1.37-7.59 0-2.61-.46-5.01-1.38-7.2-.9-2.2-2.33-4.25-4.26-6.18-1.94-1.95-4.04-3.39-6.27-4.31zM73.52 296.05h50.24l27.07-64.62c1.57-3.77 6-5.58 9.88-4.06a7.42 7.42 0 0 1 4.25 4.22l18.98 44.14h26.2l35.43-89.04c1.5-3.78 5.89-5.67 9.79-4.21a7.54 7.54 0 0 1 3.7 2.98l40.44 62.71 63.08-105.91c2.1-3.52 6.74-4.72 10.36-2.68a7.42 7.42 0 0 1 3.08 3.28l62.46 131.45V72.89H73.52v223.16zm364.96 12.45a7.332 7.332 0 0 1-1.4-2l-68.7-144.59-61.92 103.95a7.39 7.39 0 0 1-2.71 2.82c-3.55 2.15-8.23 1.09-10.44-2.36l-39.08-60.62-31.61 79.47c-.93 3.06-3.84 5.3-7.3 5.3h-36.43c-2.97-.01-5.79-1.72-7-4.55l-13.93-32.4-21.92 52.33c-1.03 2.87-3.86 4.94-7.17 4.94H73.52v37.24h364.96V308.5zM65.93 58.3h380.14c4.2 0 7.6 3.27 7.6 7.3v289.72c0 4.02-3.4 7.29-7.6 7.29H65.93c-4.2 0-7.6-3.27-7.6-7.29V65.6c0-4.03 3.4-7.3 7.6-7.3zm430.88-43.72H15.19v391.78h481.62V14.58z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            {{--  <div class="flex items-center text-center">
                                <div class="m-1.5">
                                    <!-- Start -->

                                    <!-- End -->
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div>
                    <h4 class="px-2 first:pl-5 last:pr-5 py-3 text-center whitespace-nowrap">No
                        Data Found Yet</h4>
                </div>
            @endforelse
        </div>
    </div>
