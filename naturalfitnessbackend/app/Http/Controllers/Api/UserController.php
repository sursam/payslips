<?php

namespace App\Http\Controllers\Api;

use App\Models\User\User;
use App\Traits\UploadAble;
use App\Models\Module\Pitch;
use Illuminate\Http\Request;
use App\Models\Module\Module;
use App\Models\Site\Category;
use App\Models\Company\Company;
use App\Models\Company\Director;
use App\Models\Company\Supplier;
use App\Models\Module\UserInput;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\Company\FinancialYear;
use App\Models\Company\InitialEnquiry;
use App\Models\Company\ProjectActivity;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Api\UserResource;
use App\Models\Company\FinancialQuestion;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\ProfileResource;
use App\Models\Module\ApplicationUserInput;


class UserController extends BaseController
{
    use UploadAble;
    public function initialEnquiries(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'pitch_id' => 'required|string',
        //     'company_id' => 'required|numeric',
        //     'name' => 'required|string',
        //     'email' => 'required|email',
        //     'mobile_number' => 'required|numeric',
        //     'postcode' => 'required|numeric',
        //     'full_address' => 'required|string',
        //     'registration_no' => 'required|string',
        //     'vat_no' => 'required|string',
        //     'sic_code' => 'required|string',
        //     'business_role' => 'required|numeric',
        //     // 'is_part_of_group' => 'required|numeric',
        //     // 'is_sole_trader' => 'required|numeric',
        //     'utp_no' => 'required|string',
        // ]);
        // if ($validator->fails()) {
        //     return $this->responseJson(false, 422, $validator->errors()->all(), "");
        // }
        DB::beginTransaction();
        try {
            // file :: business_bank_statment,business_bank_statment_dated
            // $dataToStore = [
            //     'user_id' => auth()->user()->id,
            //     'company_id' => $request->company_id,
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'contact_number' => $request->contact_number,
            //     'website' => $request->website,
            //     'business_name' => $request->business_name,
            //     'country_id' => $request->country_id,
            //     'postcode' => $request->postcode,
            //     'full_address' => $request->full_address,
            //     'registration_no' => $request->registration_no,
            //     'sic_code' => $request->sic_code,
            //     'vat_no' => $request->vat_no,
            //     'business_role' => $request->business_role,
            //     'is_part_of_group' => $request->is_part_of_group,
            //     'is_sole_trader' => $request->is_sole_trader,
            //     'utp_no' => $request->utp_no,
            //     'received_grand_funding_last_five_years' => $request->received_grand_funding_last_five_years,
            //     'full_time_employees' => $request->full_time_employees,
            //     'is_currently_trading' => $request->is_currently_trading,
            //     'trading_date' => $request->trading_date,
            //     'current_annual_turnover' => $request->current_annual_turnover,
            //     'sector_of_your_business' => $request->sector_of_your_business,
            //     'is_operating_btob' => $request->is_operating_btob,
            //     'rough_percentage_of_btob_sale' => $request->rough_percentage_of_btob_sale,
            //     'sort_code' => $request->sort_code,
            //     'bank_name' => $request->bank_name,
            //     'account_no' => $request->account_no,
            //     'is_verified_bank' => $request->is_verified_bank ?? 0,
            //     'is_active' => $request->is_active ?? 1
            // ];

            $dataToStore['user_id'] = auth()->user()->id;

            if(!empty($request->company_id)){
                $dataToStore['company_id'] = $request->company_id;
            }
            if(!empty($request->name)){
                $dataToStore['name'] = $request->name;
            }
            if(!empty($request->email)){
                $dataToStore['email'] = $request->email;
            }
            if(!empty($request->contact_number)){
                $dataToStore['contact_number'] = $request->contact_number;
            }
            if(!empty($request->website)){
                $dataToStore['website'] = $request->website;
            }
            if(!empty($request->business_name)){
                $dataToStore['business_name'] = $request->business_name;
            }
            if(!empty($request->country_id)){
                $dataToStore['country_id'] = $request->country_id;
            }
            if(!empty($request->postcode)){
                $dataToStore['postcode'] = $request->postcode;
            }
            if(!empty($request->full_address)){
                $dataToStore['full_address'] = $request->full_address;
            }
            if(!empty($request->registration_no)){
                $dataToStore['registration_no'] = $request->registration_no;
            }
            if(!empty($request->sic_code)){
                $dataToStore['sic_code'] = $request->sic_code;
            }
            if(!empty($request->vat_no)){
                $dataToStore['vat_no'] = $request->vat_no;
            }
            if(!empty($request->business_role)){
                $dataToStore['business_role'] = $request->business_role;
            }
            if(!empty($request->is_part_of_group)){
                $dataToStore['is_part_of_group'] = $request->is_part_of_group;
            }
            if(!empty($request->is_sole_trader)){
                $dataToStore['is_sole_trader'] = $request->is_sole_trader;
            }
            if(!empty($request->utp_no)){
                $dataToStore['utp_no'] = $request->utp_no;
            }
            if(!empty($request->received_grand_funding_last_five_years)){
                $dataToStore['received_grand_funding_last_five_years'] = $request->received_grand_funding_last_five_years;
            }
            if(!empty($request->full_time_employees)){
                $dataToStore['full_time_employees'] = $request->full_time_employees;
            }
            if(!empty($request->is_currently_trading)){
                $dataToStore['is_currently_trading'] = $request->is_currently_trading;
            }
            if(!empty($request->trading_date)){
                $dataToStore['trading_date'] = $request->trading_date;
            }
            if(!empty($request->current_annual_turnover)){
                $dataToStore['current_annual_turnover'] = $request->current_annual_turnover;
            }
            if(!empty($request->sector_of_your_business)){
                $dataToStore['sector_of_your_business'] = $request->sector_of_your_business;
            }
            if(!empty($request->is_operating_btob)){
                $dataToStore['is_operating_btob'] = $request->is_operating_btob;
            }
            if(!empty($request->rough_percentage_of_btob_sale)){
                $dataToStore['rough_percentage_of_btob_sale'] = $request->rough_percentage_of_btob_sale;
            }
            if(!empty($request->sort_code)){
                $dataToStore['sort_code'] = $request->sort_code;
            }
            if(!empty($request->bank_name)){
                $dataToStore['bank_name'] = $request->bank_name;
            }
            if(!empty($request->account_no)){
                $dataToStore['account_no'] = $request->account_no;
            }
            if(!empty($request->is_verified_bank)){
                $dataToStore['is_verified_bank'] = $request->is_verified_bank ?? 0;
            }
            if(!empty($request->is_active)){
                $dataToStore['is_active'] = $request->is_active ?? 1;
            }

            // dd($dataToStore);

            if (!empty($request->business_bank_statment)) {
                $file = $request->business_bank_statment;
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($file, config('constants.SITE_MODULE_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $dataToStore['business_bank_statment'] = $fileName;
                }
            }
            if (!empty($request->business_bank_statment_dated)) {
                $file = $request->business_bank_statment_dated;
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($file, config('constants.SITE_MODULE_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $dataToStore['business_bank_statment_dated'] = $fileName;
                }
            }
            $existPitchCheck = Pitch::where(['uuid' => $request->pitch_id])->first();
            $save = InitialEnquiry::updateOrCreate(['id' => $existPitchCheck->step_one_id], $dataToStore);
            if (empty($existPitchCheck->step_one_id)) {
                Pitch::where('uuid', $request->pitch_id)->update(['step_one_id' => $save->id, 'step' => 1]);
            }
            if ($save) {
                DB::commit();
                return $this->responseJson(true, 200, 'Data Added successfully', $save);
            }
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function addDirectors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exist_id' => 'sometimes',
            'company_id' => 'required_without:exist_id|numeric',
            'initial_enquiry_id' => 'required_without:exist_id|numeric',
            'name' => 'required|string',
            'email' => 'required|email',
            'contact_number' => 'required|integer',
            'date_of_birth' => 'required|date',
            'additional_shareholdings' => 'required|string',
            'country_id' => 'required|numeric',
            'postcode' => 'required|numeric',
            'full_address' => 'required|string',
            // 'secretary_position' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }

        DB::beginTransaction();
        try {
            if (!empty($request->exist_id)) {
                $dataToStore = array(
                    // 'user_id' => auth()->user()->id,
                    // 'company_id' => $request->company_id,
                    // 'initial_enquiry_id' => $request->initial_enquiry_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'contact_number' => $request->contact_number,
                    'date_of_birth' => $request->date_of_birth,
                    'additional_shareholdings' => $request->additional_shareholdings,
                    'country_id' => $request->country_id,
                    'postcode' => $request->postcode,
                    'full_address' => $request->full_address,
                    // 'secretary_position' => 0,
                    // 'is_active' => $request->is_active ?? 1,
                );
            } else {
                $dataToStore = array(
                    'user_id' => auth()->user()->id,
                    'company_id' => $request->company_id,
                    'initial_enquiry_id' => $request->initial_enquiry_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'contact_number' => $request->contact_number,
                    'date_of_birth' => $request->date_of_birth,
                    'additional_shareholdings' => $request->additional_shareholdings,
                    'country_id' => $request->country_id,
                    'postcode' => $request->postcode,
                    'full_address' => $request->full_address,
                    'secretary_position' => 0,
                    'is_active' => $request->is_active ?? 1,
                );
            }

            if (!empty($request->passport)) {
                $file = $request->passport;
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($file, config('constants.SITE_MODULE_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $dataToStore['passport'] = $fileName;
                }
            }
            if (!empty($request->driving_licence)) {
                $file = $request->driving_licence;
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($file, config('constants.SITE_MODULE_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $dataToStore['driving_licence'] = $fileName;
                }
            }
            if (!empty($request->exist_id)) {
                $save = Director::where('id', $request->exist_id)->update($dataToStore);
                $returnData = $dataToStore;
            } else {
                $save = Director::create($dataToStore);
                $returnData = $save;
            }
            if ($save) {
                DB::commit();
                return $this->responseJson(true, 200, 'Data Added successfully', $returnData);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function addAnotherDirectors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|numeric',
            'initial_enquiry_id' => 'required|numeric',
            'name' => 'required|string',
            // 'country_id' => 'required|numeric',
            // 'secretary_position' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }

        DB::beginTransaction();
        try {
            if (!empty($request->exist_id)) {
                $dataToStore = array(
                    // 'user_id' => auth()->user()->id,
                    // 'company_id' => $request->company_id,
                    // 'initial_enquiry_id' => $request->initial_enquiry_id,
                    'name' => $request->name,
                    // 'secretary_position' => 1,
                    // 'is_active' => $request->is_active ?? 1,
                );
            } else {
                $dataToStore = array(
                    'user_id' => auth()->user()->id,
                    'company_id' => $request->company_id,
                    'country_id' => $request->country_id,
                    'initial_enquiry_id' => $request->initial_enquiry_id,
                    'name' => $request->name,
                    'secretary_position' => 1,
                    'is_active' => $request->is_active ?? 1,
                );
            }

            if (!empty($request->passport)) {
                $file = $request->passport;
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($file, config('constants.SITE_MODULE_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $dataToStore['passport'] = $fileName;
                }
            }
            if (!empty($request->driving_licence)) {
                $file = $request->driving_licence;
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($file, config('constants.SITE_MODULE_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $dataToStore['driving_licence'] = $fileName;
                }
            }

            if (!empty($request->exist_id)) {
                $save = Director::where('id', $request->exist_id)->update($dataToStore);
            } else {
                $save = Director::create($dataToStore);
            }

            if ($save) {
                DB::commit();
                return $this->responseJson(true, 200, 'Data Added successfully', $save);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function projectActivities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pitch_id' => 'required|string',
            'company_id' => 'required|numeric',
            'activity_description' => 'required|string',
            'anticipated_started_at' => 'required|date',
            'anticipated_ended_at' => 'required|date',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }

        DB::beginTransaction();
        try {
            if (!empty($request->exist_id)) {
                $dataToStore = array(
                    // 'user_id' => auth()->user()->id,
                    // 'company_id' => $request->company_id,
                    'activity_description' => $request->activity_description,
                    'activity_total_cost_vat' => $request->activity_total_cost_vat,
                    'anticipated_started_at' => $request->anticipated_started_at,
                    'anticipated_ended_at' => $request->anticipated_ended_at,
                    'number_of_days_of_consultancy' => $request->number_of_days_of_consultancy,
                    // 'is_active' => $request->is_active ?? 1,
                );
            } else {
                $dataToStore = array(
                    'user_id' => auth()->user()->id,
                    'company_id' => $request->company_id,
                    'activity_description' => $request->activity_description,
                    'activity_total_cost_vat' => $request->activity_total_cost_vat,
                    'anticipated_started_at' => $request->anticipated_started_at,
                    'anticipated_ended_at' => $request->anticipated_ended_at,
                    'number_of_days_of_consultancy' => $request->number_of_days_of_consultancy,
                    'is_active' => $request->is_active ?? 1,
                );
            }

            if (!empty($request->evidence)) {
                $file = $request->evidence;
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($file, config('constants.SITE_MODULE_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $dataToStore['evidence'] = $fileName;
                }
            }

            $existPitchCheck = Pitch::where(['uuid' => $request->pitch_id])->first();

            if (!empty($request->exist_id)) {
                $save = ProjectActivity::where('id', $request->exist_id)->update($dataToStore);
            } else {
                $save = ProjectActivity::create($dataToStore);
            }
            if (empty($existPitchCheck->step_two_id)) {
                Pitch::where('uuid', $request->pitch_id)->update(['step_two_id' => json_encode(array($save->id)), 'step' => 2]);
            } else {
                if(empty($request->exist_id)){
                    $prev2ndIdArray = (json_decode($existPitchCheck->step_two_id));
                    array_push($prev2ndIdArray, $save->id);
                    Pitch::where('uuid', $request->pitch_id)->update(['step_two_id' => json_encode($prev2ndIdArray)]);
                }
            }
            if ($save) {
                DB::commit();
                return $this->responseJson(true, 200, 'Data Added successfully', $save);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function addSupplier(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|numeric',
            'project_activity_id' => 'required|numeric',
            'name' => 'required|string',
            'phone_number' => 'required|numeric',
            'email' => 'required|email',
            'post_code' => 'required|numeric',
            'address' => 'required|string',
            'reson_to_choose_supplier' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }

        DB::beginTransaction();
        try {
            if (empty($request->exist_id)) {
                $dataToStore = array(
                    'user_id' => auth()->user()->id,
                    'company_id' => $request->company_id,
                    'project_activity_id' => $request->project_activity_id,
                    'name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'post_code' => $request->post_code,
                    'address' => $request->address,
                    'reson_to_choose_supplier' => $request->reson_to_choose_supplier,
                    'is_active' => $request->is_active ?? 1,
                );

                $save = Supplier::create($dataToStore);
            } else {
                $dataToStore = array(
                    'name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'post_code' => $request->post_code,
                    'address' => $request->address,
                    'reson_to_choose_supplier' => $request->reson_to_choose_supplier,
                );

                $save = Supplier::where('id', (int)$request->exist_id)->update($dataToStore);
            }
            if ($save) {
                DB::commit();
                return $this->responseJson(true, 200, 'Data Added successfully', $save);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function addApplicationForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pitch_id' => 'required|string',
            'application_form' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }

        DB::beginTransaction();
        try {
            if (!empty($request->application_form)) {
                $send = [];
                $userInputIds = [];
                foreach ($request->application_form as $key => $value) {
                    $option_id = null;
                    $user_input = null;
                    if ($value['type'] == 'selectbox' || $value['type'] == 'radio' || $value['type'] == 'checkbox') {
                        $option_id = $value['input'];
                    } else {
                        $user_input = $value['input'];
                    }
                    $dataToStore = $send[] = array(
                        'user_id' => auth()->user()->id,
                        'application_form_id' => $value['application_form_id'],
                        'user_input' => $user_input ?? null,
                        'option_id' => $option_id ?? null,
                        'is_active' => 1,
                    );
                    $save = ApplicationUserInput::create($dataToStore);
                    array_push($userInputIds, $save->id);
                }
                $existPitchCheck = Pitch::where(['uuid' => $request->pitch_id])->first();
                if (empty($existPitchCheck->step_three)) {
                    Pitch::where('uuid', $request->pitch_id)->update(['step_three' => json_encode($userInputIds), 'step' => 3]);
                } else {
                    $stepThreeIds = json_decode($existPitchCheck->step_three);
                    // dd(json_decode($stepThreeIds));
                    if (!empty($stepThreeIds)) {
                        foreach ($stepThreeIds as $key => $value) {
                            // dd($value);
                            ApplicationUserInput::where('id', $value)->delete();
                        }
                    }
                    Pitch::where('uuid', $request->pitch_id)->update(['step_three' => json_encode($userInputIds)]);
                }
                if (!empty($send)) {
                    DB::commit();
                    return $this->responseJson(true, 200, 'Data Added successfully', $send);
                }
            } else {
                return $this->responseJson(false, 200, 'Param Not Found', []);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function addModuleForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }

        DB::beginTransaction();
        try {
            if (!empty($request->module)) {
                $send = [];
                foreach ($request->module as $key => $value) {
                    $option_id = null;
                    $user_input = null;
                    if ($value['type'] == 'selectbox' || $value['type'] == 'radio' || $value['type'] == 'checkbox') {
                        $option_id = $value['input'];
                    } else {
                        $user_input = $value['input'];
                    }
                    $dataToStore = $send[] = array(
                        'user_id' => auth()->user()->id,
                        'module_field_id' => $value['module_field_id'],
                        'user_input' => $user_input ?? null,
                        'option_id' => $option_id ?? null,
                        'is_active' => 1,
                    );
                    $save = UserInput::create($dataToStore);
                }
                if (!empty($send)) {
                    DB::commit();
                    return $this->responseJson(true, 200, 'Data Added successfully', $send);
                }
            } else {
                return $this->responseJson(false, 200, 'Param Not Found', []);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function updateCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }
        DB::beginTransaction();
        try {

            if (!empty($request->document)) {
                $image = $request->document;
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($image, config('constants.SITE_MODULE_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $dataToStore['document'] = $fileName;
                }
            }

            // dd(uuidtoid($request->exist_id, 'companies'));
            if (!empty($request->exist_id)) {
                $dataToStore = array(
                    'company_name' => $request->company_name,
                    'category_id' => $request->category_id ?? null,
                    'registration_number' => $request->registration_number,
                    'description' => $request->description,
                );
                $save = Company::where(['id' => uuidtoid($request->exist_id, 'companies')])->update($dataToStore);
            } else {
                $dataToStore = array(
                    'user_id' => auth()->user()->id,
                    'company_name' => $request->company_name,
                    'category_id' => $request->category_id ?? null,
                    'registration_number' => $request->registration_number,
                    'description' => $request->description,
                    'is_active' => 1,
                );
                $save = Company::create($dataToStore);
            }
            if (!empty($save)) {
                DB::commit();
                return $this->responseJson(true, 200, 'Data Added successfully', $save);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function addFinancialQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pitch_id' => 'required|string',
            'financial_year' => 'required|array',
            'module' => 'required|array',
            'financial_year_ended_at' => 'required|date',
            'assumptions_behind_your_forecasts' => 'required|string',
            'describe_your_project' => 'required|string',
            'your_current_pipeline_of_orders' => 'required|string',
            // 'applicant_company_within_the_next_six_month' => 'required|numeric',
            // 'applicant_company_details' => 'required|string',
            // 'driving_background_and_exprience_details' => 'required|string',
            // 'expected_activities_business_bank_account_details' => 'required|string',
            // 'physical_cash_taken' => 'required|string',
            // 'three_year_past_funds' => 'required|string',
            // 'business_bank_and_accountant_details' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }
        DB::beginTransaction();
        try {
            $mainDataSave = array(
                'company_id' => $request->company_id,
                'financial_year_ended_at' => $request->financial_year_ended_at,
                'assumptions_behind_your_forecasts' => $request->assumptions_behind_your_forecasts,
                'describe_your_project' => $request->describe_your_project,
                'your_current_pipeline_of_orders' => $request->your_current_pipeline_of_orders,
                'applicant_company_within_the_next_six_month' => $request->applicant_company_within_the_next_six_month,
                'applicant_company_details' => $request->applicant_company_details,
                'driving_background_and_exprience_details' => $request->driving_background_and_exprience_details,
                'expected_activities_business_bank_account_details' => $request->expected_activities_business_bank_account_details,
                'physical_cash_taken' => $request->physical_cash_taken,
                'three_year_past_funds' => $request->three_year_past_funds,
                'business_bank_and_accountant_details' => $request->business_bank_and_accountant_details,
            );
            //module added started
            $modulesIds = [];
            if (!empty($request->module)) {
                foreach ($request->module as $key => $value) {
                    $option_id = null;
                    $user_input = null;
                    if ($value['type'] == 'selectbox' || $value['type'] == 'radio' || $value['type'] == 'checkbox') {
                        $option_id = $value['input'];
                    } else {
                        $user_input = $value['input'];
                    }
                    $dataToStore = array(
                        'user_id' => auth()->user()->id,
                        'module_field_id' => $value['module_field_id'],
                        'user_input' => $user_input ?? null,
                        'option_id' => $option_id ?? null,
                        'is_active' => 1,
                    );
                    $save = UserInput::create($dataToStore);
                    array_push($modulesIds, $save->id);
                }
                $mainDataSave['module_user_input'] = json_encode($modulesIds);
            }
            //module added ended

            //financial year started
            if (!empty($request->financial_year)) {
                foreach ($request->financial_year as $key => $f_year) {
                    $fYearInsert = array(
                        'turnover' => $f_year['turnover'],
                        'cost_of_sales' => $f_year['cost_of_sales'],
                        'gross_profit_auto_fill' => $f_year['gross_profit_auto_fill'],
                        'expenses' => $f_year['expenses'],
                        'net_profit_auto_fill' => $f_year['net_profit_auto_fill']
                    );
                    $fYearSave = FinancialYear::create($fYearInsert);
                    if ($key == 0) {
                        $mainDataSave['two_year_ago_info_id'] = $fYearSave->id;
                    } else if ($key == 1) {
                        $mainDataSave['one_year_ago_info_id'] = $fYearSave->id;
                    } else if ($key == 2) {
                        $mainDataSave['current_year_info_id'] = $fYearSave->id;
                    } else if ($key == 3) {
                        $mainDataSave['one_year_before_info_id'] = $fYearSave->id;
                    } else if ($key == 4) {
                        $mainDataSave['two_year_before_info_id'] = $fYearSave->id;
                    }
                }
            }
            $existPitchCheck = Pitch::where(['uuid' => $request->pitch_id])->first();
            $financialQuestion = FinancialQuestion::updateOrCreate(['id' => $existPitchCheck->step_four_id], $mainDataSave);
            if (empty($existPitchCheck->step_four_id)) {
                Pitch::where('uuid', $request->pitch_id)->update(['step_four_id' => $financialQuestion->id, 'step' => 4]);
            }
            // $financialQuestion = FinancialQuestion::create($mainDataSave);
            if (!empty($financialQuestion)) {
                //pitch add start
                Pitch::where('uuid', $request->pitch_id)->update(['step_four_id' => $financialQuestion->id, 'step' => 4]);
                //pitch add end
                DB::commit();
                return $this->responseJson(true, 200, 'Data Added successfully', $financialQuestion);
            }
            //financial year ended
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function pitchCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }
        DB::beginTransaction();
        try {
            $fYearInsert = array(
                'company_id' => $request->company_id,
                'is_active' => 1
            );
            $fYearSave = Pitch::create($fYearInsert);
            if (!empty($fYearSave)) {
                DB::commit();
                return $this->responseJson(true, 200, 'Pitch Added successfully', ['pitch_id' => $fYearSave->uuid]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function getProfile()
    {
        try {
            $user = auth()->user();
            if (!empty($user)) {
                return $this->responseJson(true, 200, 'User Details Found', new ProfileResource($user));
            }
        } catch (\Throwable $e) {
            dd($e);
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function deleteDirectors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'director_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }
        DB::beginTransaction();
        try {
            $delete = Director::where('id', $request->director_id)->delete();
            if (!empty($delete)) {
                DB::commit();
                return $this->responseJson(true, 200, 'Director deleted successfully', []);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
}
