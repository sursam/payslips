<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Models\Site\Category;
use App\Models\Vehicle\VehicleType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Api\VehicleTyperesource;
use App\Services\Category\CategoryService;

class DashboardController extends BaseController
{
    public function __construct(protected CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    // public function getVehicleTypes()
    // {
    //     $filterConditions = ['type' => 'vehicle', 'parent_id' => null];
    //     $isvehicleTypes = $this->categoryService->listCategories($filterConditions);
    //     $message = $isvehicleTypes->isNotEmpty() ? "Vehicle types found successfully" : "Vehicle types not found";
    //     return $this->responseJson(true, 200, $message, VehicleTyperesource::collection($isvehicleTypes));
    // }
}
