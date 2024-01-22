<?php

namespace App\Http\Controllers\Admin\Fare;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Services\Fare\HelperFareService;

class HelperFareController extends BaseController
{
    public function __construct(protected HelperFareService $helperFareService){
        $this->helperFareService= $helperFareService;
    }
    public function index(Request $request){
        $this->setPageTitle('Helper Fares List');
        $helperFares = $this->helperFareService->listHelperFares([]);
        // dd($helperFares);
        return view('admin.helper-fares.list', compact('helperFares'));
    }
    public function alter(Request $request){
        if ($request->post()) {
            $request->validate([
                'count' => 'required',
                "amount" => 'required',
            ]);
            
            DB::beginTransaction();
            try {
                $fareId = $request->id ? $request->id : null;
                // dd($request->all());
                $isFareAltered = $this->helperFareService->createOrUpdateHelperFare($request->except('_token'), $request->id);
                
                if ($isFareAltered) {
                    DB::commit();
                    $successMsg = $request->id ? 'Helper fare updated successfully' : 'Helper fare created successfully';
                    return $this->responseJson(true, 200, $successMsg);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack(false, 500, 'Something went wrong');
            }
        }
    }
}
