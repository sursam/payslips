<?php

namespace App\Http\Controllers\Api\Driver;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use App\Models\Vehicle\VehicleCompany;
use App\Http\Controllers\BaseController;
use App\Services\Company\CompanyService;
use App\Services\Vehicle\VehicleService;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\CompanyResource;
use App\Http\Resources\Api\VehicleResource;

class VehicleController extends BaseController
{
    public function __construct(protected VehicleService $vehicleService, protected CompanyService $companyService){
        $this->vehicleService= $vehicleService;
        $this->companyService= $companyService;
    }
    public function getVehicleCompanies()
    {
        $filterConditions = [];
        $isvehicleCompanies = $this->companyService->listCompanies($filterConditions);
        $message = $isvehicleCompanies->isNotEmpty() ? "Vehicle companies found successfully" : "Vehicle companies not found";
        return $this->responseJson(true, 200, $message, CompanyResource::collection($isvehicleCompanies));
    }
    public function addVehicle(Request $request)
    {
        {
            $validator = Validator::make($request->all(), [
                "name"        => "required|string",
                "category_id"     => "required|exists:categories,uuid",
                "image"            => "required|mimes:png,jpg,jpeg",
                "aadhar_image"         => "required|mimes:png,jpg,jpeg",
                "license_image"            => "required|mimes:png,jpg,jpeg",
                "registration_number"               => "required|string",
                "company_id"            => "required|exists:vehicle_companies,uuid",
                "vehicle_image"            => "required|mimes:png,jpg,jpeg"
            ]);
            if ($validator->fails()) return $this->responseJson(false, 422, $validator->errors()->first(), '');
            // try {
                // $isVehicleCreated = $this->vehicleService->createOrUpdateVehicle($request->except('_token'));
                $isUserImageUpdated = $this->userService->createDriver($request->except('_token'), auth()->user()->id);

                if($isUserImageUpdated){
                    return $this->responseJson(true, 200, "Vehicle created successfully");
                }

            // } catch (\Exception $e) {
            //     logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            //     return $this->responseJson(false, 500, "Something went wrong");
            // }
        }
    }
    public function getVehicleInfo()
    {
        $isvehicleInfo = auth()->user()->vehicle ? new VehicleResource(auth()->user()->vehicle) : (object)[];
        $message = auth()->user()->vehicle ? "Vehicle info found successfully" : "Vehicle info not found";
        return $this->responseJson(true, 200, $message, $isvehicleInfo);
    }
}
