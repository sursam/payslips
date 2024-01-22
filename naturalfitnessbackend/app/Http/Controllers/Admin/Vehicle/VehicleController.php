<?php

namespace App\Http\Controllers\Admin\Vehicle;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Services\Company\CompanyService;
use App\Services\Vehicle\VehicleService;
use App\Services\Category\CategoryService;

class VehicleController extends BaseController
{
    public function __construct(protected VehicleService $vehicleService,
        protected CategoryService $categoryService,
        protected CompanyService $companyService){
        $this->vehicleService= $vehicleService;
        $this->categoryService = $categoryService;
        $this->companyService = $companyService;
    }
    public function index(Request $request){
        $this->setPageTitle('List Vehicles');
        return view('admin.vehicle.list');
    }
    public function add(Request $request){
        $this->setPageTitle('Add Vehicle');
        if ($request->post()) {
            $request->validate([
                'registration_number' => 'required',
                'company_id' => 'required',
                "type_id" => 'required',
                "user_id" => 'required',
            ]);
            DB::beginTransaction();
            try {
                $isVehicleCreated = $this->vehicleService->createOrUpdateVehicle($request->except('_token'));
                if ($isVehicleCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.vehicle.list', 'Vehicle created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.vehicle.add');
    }
    public function edit(Request $request,$uuid){
        $this->setPageTitle('Edit Vehicle');
        $filterConditions= [
            'status'=> true
        ];
        $vehicleId= uuidtoid($uuid,'vehicles');
        $vehicleData= $this->vehicleService->findVehicleById($vehicleId);
        if($request->post()){
            DB::beginTransaction();
             try{
                $isVehicleUpdated= $this->vehicleService->createOrUpdateVehicle($request->except('_token'),$vehicleId);
                if($isVehicleUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.vehicle.list','Vehicle updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.vehicle.edit',compact('vehicleData'));
    }
    public function listVehicleType(Request $request, $uuid = ''){
        $this->setPageTitle('List Vehicle Types');
        return view('admin.vehicle.types.list',compact('uuid'));
    }
    public function listVehicleSubType(Request $request){
        $this->setPageTitle('List Vehicle Types');
        return view('admin.vehicle.types.sub-categories');
    }
    public function addVehicleType(Request $request){
        $this->setPageTitle('Add Vehicle Type');
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $request->merge(['type' => 'vehicle']);
                $isVehicleCreated = $this->categoryService->createOrUpdateCategory($request->except('_token'));
                if ($isVehicleCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.vehicle.type.list', 'Vehicle type created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.vehicle.types.add');
    }
    public function editVehicleType(Request $request,$uuid){
        $this->setPageTitle('Edit Vehicle Type');
        $vehicleTypeId= uuidtoid($uuid,'categories');
        $vehicleTypeData= $this->categoryService->findCategoryById($vehicleTypeId);
        if($request->post()){
            DB::beginTransaction();
             try{
                $request->merge(['type' => 'vehicle']);
                $isVehicleUpdated= $this->categoryService->createOrUpdateCategory($request->except('_token'),$vehicleTypeId);
                if($isVehicleUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.vehicle.type.list','Vehicle type updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.vehicle.types.edit',compact('vehicleTypeData'));
    }

    public function listVehicleCompany(Request $request){
        $this->setPageTitle('List Vehicle Companies');
        return view('admin.vehicle.companies.list');
    }
    public function addVehicleCompany(Request $request){
        $this->setPageTitle('Add Vehicle Company');
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $request->merge(['user_id' => auth()->user()->id]);
                $isVehicleCreated = $this->companyService->createOrUpdateCompany($request->except('_token'));
                if ($isVehicleCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.vehicle.company.list', 'Vehicle company created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.vehicle.companies.add');
    }
    public function editVehicleCompany(Request $request,$uuid){
        $this->setPageTitle('Edit Vehicle Company');
        $vehicleCompanyId = uuidtoid($uuid,'companies');
        $vehicleCompanyData = $this->companyService->findById($vehicleCompanyId);
        if($request->post()){
            DB::beginTransaction();
             try{
                $request->merge(['user_id' => auth()->user()->id]);
                $isVehicleUpdated= $this->companyService->createOrUpdateCompany($request->except('_token'),$vehicleCompanyId);
                if($isVehicleUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.vehicle.company.list','Vehicle company updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.vehicle.companies.edit',compact('vehicleCompanyData'));
    }

    public function listVehicleBodyType(Request $request, $uuid = ''){
        $this->setPageTitle('List Vehicle Body Types');
        return view('admin.vehicle.body-types.list',compact('uuid'));
    }
    public function editVehicleBodyType(Request $request,$uuid){
        $this->setPageTitle('Edit Vehicle Body Type');
        $vehicleTypeId= uuidtoid($uuid,'categories');
        $vehicleTypeData= $this->categoryService->findCategoryById($vehicleTypeId);
        //dd($vehicleTypeData->parent->uuid);
        if($request->post()){
            DB::beginTransaction();
             try{
                $request->merge(['type' => 'vehicle_body']);
                $isVehicleUpdated= $this->categoryService->createOrUpdateCategory($request->except('_token'),$vehicleTypeId);
                if($isVehicleUpdated){
                    DB::commit();
                    return $this->responseRedirectWithQueryString('admin.vehicle.body.type.list', [$vehicleTypeData->parent->uuid],'Vehicle body type updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.vehicle.body-types.edit',compact('vehicleTypeData'));
    }
}
