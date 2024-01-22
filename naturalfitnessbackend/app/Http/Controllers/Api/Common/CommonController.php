<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Payment\PaymentService;
use App\Services\Category\CategoryService;
use App\Http\Resources\Api\PaymentModeResource;
use App\Http\Resources\Api\VehicleTyperesource;

class CommonController extends BaseController
{
    public function __construct(protected CategoryService $categoryService, protected PaymentService $paymentService)
    {
        $this->categoryService = $categoryService;
        $this->paymentService = $paymentService;
    }
    public function getVehicleTypes(Request $request)
    {
        $filterConditions = ['type' => 'vehicle', 'parent_id' => null];
        $isvehicleTypes = $this->categoryService->listCategories($filterConditions);
        $message = $isvehicleTypes->isNotEmpty() ? "Vehicle types found successfully" : "Vehicle types not found";
        return $this->responseJson(true, 200, $message, VehicleTyperesource::collection($isvehicleTypes));
    }
    public function getPaymentModes(Request $request)
    {
        $filterConditions = [];
        $isPaymentMode = $this->paymentService->listPaymentModes($filterConditions);
        $message = $isPaymentMode->isNotEmpty() ? "Payment Modes found successfully" : "Payment Modes not found";
        return $this->responseJson(true, 200, $message, PaymentModeResource::collection($isPaymentMode));
    }
}
