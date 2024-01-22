@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y items-center mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-6">
            <x-driver-tab :userData=$userData :currentTab=$currentTab />
        </div>
        <div class="col-6 col-span-6 text-right">
            <a href="{{ route('admin.driver.list', $userData->vehicle?->vehicleType?->slug) }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="font-medium text-center lg:text-left">
                    <h2 class="font-medium text-base mr-auto">{{ __('Recharge Wallet') }}</h2>
                    <form class="formSubmit rechargeForm" id="rechargeForm" method="post">
                        @csrf

                        <div class="grid grid-cols-12 gap-6 mt-5">
                            @forelse ($rechargeAmounts as $rechargeAmount)
                                <div class="col-span-3 lg:col-span-3">
                                    <label class="recharge-amount-label">
                                        <input type="radio" class="recharge-default-amount" name="rechargeDefaultAmount" value="{{ $rechargeAmount }}" /> {{ $rechargeAmount }}</label>
                                </div>
                            @empty
                            @endforelse
                            <div class="col-span-12 lg:col-span-12">
                                <div class="input-group">
                                    <input type="number" class="form-control recharge-custom-amount" placeholder="{{ __('Enter custom amount') }}" name="rechargeCustomAmount" />
                                </div>
                            </div>
                        </div>
                        @error('rechargeAmount')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div>
                            <input type="hidden" class="recharge-amount" name="rechargeAmount" />
                            <button type="submit" class="btn btn-warning btn-icon-split mt-4">
                                <span class="icon text-white-50">
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                </span>
                                <span class="text ml-2">Recharge Now</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3"><span class="icon text-white-50"><i class="fas fa-wallet"></i></span> {{ __('Available wallet balance: ') }}</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <span class="text">₹ {{ number_format((float)($userData->wallet?->balance ? $userData->wallet?->balance : 0), 2, '.', '') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="intro-y tab-content mt-5">
        <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            {{ __('Recharge History') }}
                        </h2>

                    </div>
                    <div class="p-5">
                        <table class="table table-report -mt-2 customdatatable" id="transactionsTable" data-user_uuid="{{ $userData->uuid }}">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>id</th>
                                    <th>Transaction Id</th>
                                    <th style="width: 40%;">Transaction Details</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        {{--  <div class="flex flex-col sm:flex-row">
                            <div class="flex">
                                <div class="grid grid-cols-12 gap-6">
                                    @forelse ($walletData->transactions as $transaction)
                                        <div class="col-span-12 lg:col-span-12">
                                            <div class="txn-no">
                                                Transaction ID
                                                {{ __('#') }} {{ $transaction->transaction_no }}
                                                {{ $transaction->created_at->format('jS M Y') }}
                                            </div>
                                            <div class="txn-amount">
                                                <span class="icon text-white-50"><i class="fas fa-credit-card"></i> Transaction Amount </span>{{ $transaction->currency }} {{ $transaction->amount }}
                                            </div>
                                            <div class="amount">
                                                {{ $transaction->currency }} {{ $transaction->amount * getSiteSetting('site_commission_percentage') }}
                                                {{ ($transaction->type == 'credit') ? 'Credited to' : 'Dabit from' }} <span class="icon text-white-50"><i class="fas fa-wallet"></i></span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-12 lg:col-span-12">
                                            <p>No transactions are available.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatableajax.js') }}"></script>
@endpush
