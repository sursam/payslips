@extends('admin.layouts.app')
@push('styles')
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200 ">
            <div class="sm:flex sm:justify-between sm:items-center my-4 justify-content-end">
                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                    <a class="btn bg-indigo-500 hover:bg-indigo-600 text-white addCostBtn" href="javascript:void(0)" data-count="1">
                         <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Add More Cost</span>
                    </a>
                </div>
            </div>
            <form method="post" id="shippingForm" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8 addCostContainer">
                    <div class="card p-2">
                        <div class="grid gap-3 md:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium mb-1" for="country-1">Country <span
                                        class="text-rose-500">*</span></label>
                                        <select class="form-select getPopulate countries required" id="country-1" name="shipping[1][country]" data-location="state-1" data-message="state">
                                            <option value="">Select Country</option>
                                            @forelse ($countryList as $country)
                                                <option value="{{ $country->id }}" data-populate="{{ json_encode($country->states->pluck('slug','id')) }}">{{ $country->name }}</option>
                                            @empty

                                            @endforelse
                                        </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 " for="state-1" >State <span
                                        class="text-rose-500">*</span></label>
                                        <select class="form-select states required" id="state-1" name="shipping[1][state]" data-location="city-1" data-message="No city found"></select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="city-1">City <span
                                        class="text-rose-500">*</span></label>
                                        <select class="form-select cities required" id="city-1" name="shipping[1][city]"></select>
                            </div>
                        </div>
                        <div class="grid gap-2 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium mb-1" for="city-1">Pincodes(e.g:123456,123456,234567....)</label>
                                        <textarea class="form-input w-full" rows="2" name="shipping[1][pincode]"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="cost-1">Cost <span
                                        class="text-rose-500">*</span></label>
                                        <input type="number" class="form-control form-input w-full cost required" name="shipping[1][cost]">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-8 mt-8">
                    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white addCost" type="submit">
                            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z">
                                </path>
                            </svg>
                            <span class="hidden xs:block ml-2">Add Costs</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/admin/js/shipping.js') }}"></script>
@endpush
