@extends('admin.layouts.app', ['isSidebar' => true, 'isNavbar' => true, 'isFooter' => false])
@push('styles')
@endpush

@section('content')
    <div class="intro-y items-center mt-8 grid grid-cols-12">
        <div class="col-span-6">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="initialenquiries-tab" data-bs-toggle="tab"
                        data-bs-target="#initialenquiries" type="button" role="tab" aria-controls="initialenquiries"
                        aria-selected="true"> {{ __('Initial Enquiries') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profileactivity-tab" data-bs-toggle="tab" data-bs-target="#profileactivity"
                        type="button" role="tab" aria-controls="profileactivity" aria-selected="false">
                        {{ __('Project Activites') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="application-tab" data-bs-toggle="tab" data-bs-target="#application"
                        type="button" role="tab" aria-controls="application" aria-selected="false">
                        {{ __('Application Form') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="fqir-tab" data-bs-toggle="tab" data-bs-target="#fqir" type="button"
                        role="tab" aria-controls="fqir" aria-selected="false">
                        {{ __('Financial Question & Information Request') }}</button>
                </li>
            </ul>
        </div>
        <div class="col-6 col-span-6 text-right">
            <a href="{{ route('admin.grant.pitch.list') }}" class="btn btn-warning btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
        <div class="col-12 col-span-12">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="initialenquiries" role="tabpanel"
                    aria-labelledby="initialenquiries-tab">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                            <!-- BEGIN: Add User Form -->
                            <div class="intro-y box ">
                                <div class="p-5 grid grid-cols-12 gap-6">

                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Name') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->name ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Email') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->email ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Contact Number ') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->contact_number ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Website') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->website ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Business Name') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->business_name ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Full Address') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->full_address ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Post Code') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->postcode ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Registration No') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->registration_no ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('SIC Code') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->sic_code ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('VAT No') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->vat_no ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Business Role') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->business_role ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Part of Group') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->is_part_of_group ? 'Yes' : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('UTP No') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->utp_no ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1"
                                            class="form-label">{{ __('Full Time Employees') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->full_time_employees ?? '' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Currently Trading') }}</label>
                                        : <b
                                            class="optionVal">{{ $initialEnquiry?->is_currently_trading ? 'Yes' : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Trading Date') }}</label>
                                        : <b
                                            class="optionVal">{{ $initialEnquiry?->trading_date ? date('dS M Y', strtotime($initialEnquiry->trading_date)) : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1"
                                            class="form-label">{{ __('Current Annual Turnover') }}</label>
                                        : <b
                                            class="optionVal">{{ $initialEnquiry?->current_annual_turnover ? $initialEnquiry->current_annual_turnover : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1"
                                            class="form-label">{{ __('Sector of Your Business') }}</label>
                                        : <b
                                            class="optionVal">{{ $initialEnquiry?->sector_of_your_business ? $initialEnquiry->sector_of_your_business : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Is Operating Btob') }}</label>
                                        : <b
                                            class="optionVal">{{ $initialEnquiry?->is_operating_btob ? $initialEnquiry->is_operating_btob : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1"
                                            class="form-label">{{ __('Rough Percentage of Btob Sale') }}</label>
                                        : <b
                                            class="optionVal">{{ $initialEnquiry?->rough_percentage_of_btob_sale ? $initialEnquiry->rough_percentage_of_btob_sale : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Sort Code') }}</label>
                                        : <b
                                            class="optionVal">{{ $initialEnquiry?->sort_code ? $initialEnquiry->sort_code : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Bank Name') }}</label>
                                        : <b
                                            class="optionVal">{{ $initialEnquiry?->bank_name ? $initialEnquiry->bank_name : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Account No') }}</label>
                                        : <b
                                            class="optionVal">{{ $initialEnquiry?->account_no ? $initialEnquiry->account_no : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1" class="form-label">{{ __('Verified Bank') }}</label>
                                        : <b class="optionVal">{{ $initialEnquiry?->is_verified_bank ? 'Yes' : 'No' }}</b>
                                    </div>
                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                        <label for="name-form-1"
                                            class="form-label">{{ __('Bank Statment Dated') }}</label>
                                        : <b
                                            class="optionVal">{{ $initialEnquiry?->business_bank_statment_dated ? date('dS M Y', strtotime($initialEnquiry->business_bank_statment_dated)) : '' }}</b>
                                    </div>
                                </div>

                                <div class="p-5 grid grid-cols-12 gap-6">
                                    @if (!empty($initialEnquiry->director))
                                        @foreach ($initialEnquiry->director as $dkey => $director)
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <div class="directorsTab">
                                                    <h3>Directors {{ $dkey + 1 }}</h3>
                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Name :: {{ $director->name ?? '' }}
                                                                {{ $director->secretary_position == 0 ? '(Own)' : '(Other)' }}
                                                            </h5>
                                                            <p class="card-text">
                                                                DOB :: <b>{{ $director->date_of_birth ?? 'N/A' }}</b>
                                                                <br>Email :: <b>{{ $director->email ?? 'N/A' }}</b>
                                                                <br>Constact No ::
                                                                <b>{{ $director->contact_number ?? 'N/A' }}</b>
                                                                <br>Additional Shareholdings ::
                                                                <b>{{ $director->additional_shareholdings ?? 'N/A' }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <!-- END: Add User Form -->
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profileactivity" role="tabpanel" aria-labelledby="profileactivity-tab">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                            <!-- BEGIN: Add User Form -->
                            {{-- @dd($projectActivity); --}}
                            @if (!empty($projectActivity))
                                @foreach ($projectActivity as $projActKey => $projActVal)
                                    <div class="intro-y box {{ $projActKey != 0 ? 'mt-3' : '' }}">
                                        <div class="p-5 cols-12">
                                            <strong><u>Project Activites {{ $projActKey + 1 }}</u></strong>
                                        </div>
                                        <div class="p-5 grid grid-cols-12 gap-6">
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <label for="name-form-1"
                                                    class="form-label">{{ __('Activity Description') }}</label>
                                                : <b
                                                    class="optionVal">{{ $projActVal?->activity_description ?? 'N/A' }}</b>
                                            </div>
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <label for="name-form-1"
                                                    class="form-label">{{ __('Activity Total Cost Vat') }}</label>
                                                : <b
                                                    class="optionVal">{{ $projActVal?->activity_total_cost_vat ?? 'N/A' }}</b>
                                            </div>
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <label for="name-form-1"
                                                    class="form-label">{{ __('Activity Total Cost Vat') }}</label>
                                                : <b
                                                    class="optionVal">{{ $projActVal?->activity_total_cost_vat ?? 'N/A' }}</b>
                                            </div>
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <label for="name-form-1"
                                                    class="form-label">{{ __('Anticipated Started At') }}</label>
                                                : <b
                                                    class="optionVal">{{ $projActVal?->anticipated_started_at ?? 'N/A' }}</b>
                                            </div>
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <label for="name-form-1"
                                                    class="form-label">{{ __('Anticipated Ended At') }}</label>
                                                : <b
                                                    class="optionVal">{{ $projActVal?->anticipated_ended_at ?? 'N/A' }}</b>
                                            </div>
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <label for="name-form-1"
                                                    class="form-label">{{ __('Number of days of consultancy') }}</label>
                                                : <b
                                                    class="optionVal">{{ $projActVal?->number_of_days_of_consultancy ?? 'N/A' }}</b>
                                            </div>
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <label for="name-form-1" class="form-label">{{ __('Evidence') }}</label>
                                                : <b class="optionVal">{{ $projActVal?->evidence ?? 'N/A' }}</b>
                                            </div>
                                        </div>

                                        <div class="p-5 grid grid-cols-12 gap-6">
                                            @if (!empty($projActVal->supplier))
                                                @foreach ($projActVal->supplier as $dkey => $supplier)
                                                    <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                        <div class="directorsTab">
                                                            <h3>suppliers {{ $dkey + 1 }}</h3>
                                                            <div class="card" style="width: 18rem;">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Name ::
                                                                        {{ $supplier->name ?? '' }}
                                                                    </h5>
                                                                    <p class="card-text">
                                                                        Phone Number ::
                                                                        <b>{{ $supplier->phone_number ?? 'N/A' }}</b>
                                                                        <br>Email :: <b>{{ $supplier->email ?? 'N/A' }}</b>
                                                                        <br>Post Code ::
                                                                        <b>{{ $supplier->post_code ?? 'N/A' }}</b>
                                                                        <br>Address ::
                                                                        <b>{{ $supplier->address ?? 'N/A' }}</b>
                                                                        <br>Reson to choose supplier ::
                                                                        <b>{{ $supplier->reson_to_choose_supplier ?? 'N/A' }}</b>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="application" role="tabpanel" aria-labelledby="application-tab">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                            <div class="intro-y box ">
                                <div class="p-5 grid grid-cols-12 gap-6">
                                    @if (!empty($applicationForm))
                                        @foreach ($applicationForm as $applyKey => $applyValue)
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <label for="name-form-1"
                                                    class="form-label">{{ $applyValue->applicationForm?->question }}</label>
                                                : <b
                                                    class="optionVal">{{ $applyValue?->user_input ? $applyValue?->user_input : $applyValue?->application_form_options?->option_value }}</b>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($financialQuestion);
                    <div class="tab-pane fade" id="fqir" role="tabpanel" aria-labelledby="fqir-tab">
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                                <div class="intro-y box ">
                                    <div class="p-5 grid grid-cols-12 gap-6">

                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('What is your Finantial Year End Date') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->financial_year_ended_at ?? 'N/A' }}</b>
                                        </div>
                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('Assumptions Behind Your Forecasts') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->assumptions_behind_your_forecasts ?? 'N/A' }}</b>
                                        </div>
                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('Describe your project') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->describe_your_project ?? 'N/A' }}</b>
                                        </div>
                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('Your current pipeline of orders') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->your_current_pipeline_of_orders ?? 'N/A' }}</b>
                                        </div>
                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('Applicant company within the next six month') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->applicant_company_within_the_next_six_month == 1 ? 'Yes' : 'No' }}</b>
                                        </div>
                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('Applicant company details') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->applicant_company_details ?? '' }}</b>
                                        </div>
                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('Driving background and exprience details') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->driving_background_and_exprience_details ?? '' }}</b>
                                        </div>
                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('Expected activities business bank account details') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->expected_activities_business_bank_account_details ?? '' }}</b>
                                        </div>
                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('Physical cash taken?') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->physical_cash_taken ?? '' }}</b>
                                        </div>
                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('What funds have been injected into the business in the past 3 years') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->three_year_past_funds ?? '' }}</b>
                                        </div>
                                        <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                            <label for="name-form-1"
                                                class="form-label">{{ __('Who does the business bank with and who do you use as your accountant?') }}</label>
                                            : <b
                                                class="optionVal">{{ $financialQuestion?->business_bank_and_accountant_details ?? '' }}</b>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="p-5 grid grid-cols-12 gap-6">
                                        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                                            <b class="mt-5">Module</b>
                                        </div>
                                        @if (!empty($financialQuestion->module_user_input))
                                            @foreach ($financialQuestion->module_user_input as $mkey => $module)
                                                <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                    {{ $module['module_field']['module']['title'] }}
                                                    <label for="name-form-1"
                                                        class="form-label">{{ $module['module_field']['question'] ?? 'N/A' }}</label>
                                                    : <b class="optionVal">{{ $module['user_input'] ?? 'N/A' }}</b>
                                                </div>
                                            @endforeach
                                        @else
                                            <h2>No Data Found</h2>
                                        @endif
                                    </div>
                                    <hr>
                                    <div class="p-5 grid grid-cols-12 gap-6">
                                        @if (!empty($financialQuestion->twoYearsAgo))
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <div class="directorsTab">
                                                    <h3>Financial Year (2 Year ago)</h3>
                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <p class="card-text">
                                                                Turnover ::
                                                                <b>{{ $financialQuestion->twoYearsAgo?->turnover ?? 'N/A' }}</b>
                                                                <br>Cost of sales ::
                                                                <b>{{ $financialQuestion->twoYearsAgo?->cost_of_sales ?? 'N/A' }}</b>
                                                                <br>Gross profit auto fill ::
                                                                <b>{{ $financialQuestion->twoYearsAgo?->gross_profit_auto_fill ?? 'N/A' }}</b>
                                                                <br>Expenses ::
                                                                <b>{{ $financialQuestion->twoYearsAgo?->expenses ?? 'N/A' }}</b>
                                                                <br>Net profit auto fill ::
                                                                <b>{{ $financialQuestion->twoYearsAgo?->net_profit_auto_fill ?? 'N/A' }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($financialQuestion->oneYearsAgo))
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <div class="directorsTab">
                                                    <h3>Financial Year (1 Year ago)</h3>
                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <p class="card-text">
                                                                Turnover ::
                                                                <b>{{ $financialQuestion->oneYearsAgo?->turnover ?? 'N/A' }}</b>
                                                                <br>Cost of sales ::
                                                                <b>{{ $financialQuestion->oneYearsAgo?->cost_of_sales ?? 'N/A' }}</b>
                                                                <br>Gross profit auto fill ::
                                                                <b>{{ $financialQuestion->oneYearsAgo?->gross_profit_auto_fill ?? 'N/A' }}</b>
                                                                <br>Expenses ::
                                                                <b>{{ $financialQuestion->oneYearsAgo?->expenses ?? 'N/A' }}</b>
                                                                <br>Net profit auto fill ::
                                                                <b>{{ $financialQuestion->oneYearsAgo?->net_profit_auto_fill ?? 'N/A' }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($financialQuestion->currentYears))
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <div class="directorsTab">
                                                    <h3>Financial Year (Current Year)</h3>
                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <p class="card-text">
                                                                Turnover ::
                                                                <b>{{ $financialQuestion->currentYears?->turnover ?? 'N/A' }}</b>
                                                                <br>Cost of sales ::
                                                                <b>{{ $financialQuestion->currentYears?->cost_of_sales ?? 'N/A' }}</b>
                                                                <br>Gross profit auto fill ::
                                                                <b>{{ $financialQuestion->currentYears?->gross_profit_auto_fill ?? 'N/A' }}</b>
                                                                <br>Expenses ::
                                                                <b>{{ $financialQuestion->currentYears?->expenses ?? 'N/A' }}</b>
                                                                <br>Net profit auto fill ::
                                                                <b>{{ $financialQuestion->currentYears?->net_profit_auto_fill ?? 'N/A' }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($financialQuestion->oneYearsBefore))
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <div class="directorsTab">
                                                    <h3>Financial Year (One Year Before)</h3>
                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <p class="card-text">
                                                                Turnover ::
                                                                <b>{{ $financialQuestion->oneYearsBefore?->turnover ?? 'N/A' }}</b>
                                                                <br>Cost of sales ::
                                                                <b>{{ $financialQuestion->oneYearsBefore?->cost_of_sales ?? 'N/A' }}</b>
                                                                <br>Gross profit auto fill ::
                                                                <b>{{ $financialQuestion->oneYearsBefore?->gross_profit_auto_fill ?? 'N/A' }}</b>
                                                                <br>Expenses ::
                                                                <b>{{ $financialQuestion->oneYearsBefore?->expenses ?? 'N/A' }}</b>
                                                                <br>Net profit auto fill ::
                                                                <b>{{ $financialQuestion->oneYearsBefore?->net_profit_auto_fill ?? 'N/A' }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($financialQuestion->twoYearsBefore))
                                            <div class="col-span-6 lg:col-span-6 2xl:col-span-6">
                                                <div class="directorsTab">
                                                    <h3>Financial Year (Two Year Before)</h3>
                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <p class="card-text">
                                                                Turnover ::
                                                                <b>{{ $financialQuestion->twoYearsBefore?->turnover ?? 'N/A' }}</b>
                                                                <br>Cost of sales ::
                                                                <b>{{ $financialQuestion->twoYearsBefore?->cost_of_sales ?? 'N/A' }}</b>
                                                                <br>Gross profit auto fill ::
                                                                <b>{{ $financialQuestion->twoYearsBefore?->gross_profit_auto_fill ?? 'N/A' }}</b>
                                                                <br>Expenses ::
                                                                <b>{{ $financialQuestion->twoYearsBefore?->expenses ?? 'N/A' }}</b>
                                                                <br>Net profit auto fill ::
                                                                <b>{{ $financialQuestion->twoYearsBefore?->net_profit_auto_fill ?? 'N/A' }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/editor.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-tagsinput.js') }}"></script>
    <script>
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword']) ? $seo['meta_keyword'] : ''; ?>";
        $('#meta_keyword').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#meta_keyword').tagsinput('add', meta_keyword_values);
    </script>
@endpush
