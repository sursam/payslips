<?php

namespace App\Http\Controllers\Admin\Fare;

use Illuminate\Http\Request;
use App\Services\Fare\FareService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Services\Category\CategoryService;

class FareController extends BaseController
{
    public function __construct(
        protected FareService $fareService,
        protected CategoryService $categoryService
    ){
        $this->fareService= $fareService;
        $this->categoryService= $categoryService;
    }
    public function index(Request $request){
        $this->setPageTitle('Fares List');
        $categories = $this->categoryService->listCategories(['parent_id' => null, 'type' => 'vehicle']);
        //dd($categories);
        return view('admin.fares.index', compact('categories'));
    }
    public function alter(Request $request){
        if ($request->post()) {
            $request->validate([
                'category_id' => 'required',
                'start_at' => 'required',
                "end_at" => 'required',
                "amount" => 'required',
            ]);
            DB::beginTransaction();
            try {
                $fareId = $request->id ? $request->id : null;
                $isFareAltered = $this->fareService->createOrUpdateFare($request->except('_token'), $request->id);
                if ($isFareAltered) {
                    DB::commit();
                    $successMsg = $request->id ? 'Fare updated successfully' : 'Fare created successfully';
                    return $this->responseJson(true, 200, $successMsg);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack(false, 500, 'Something went wrong');
            }
        }
    }

    public function add(Request $request){
        $this->setPageTitle('Add Fare');
        if ($request->post()) {
            $request->validate([
                'category_id' => 'required',
                'start_at' => 'required',
                "end_at" => 'required',
                "amount" => 'required',
            ]);
            DB::beginTransaction();
            try {
                $ispageCreated = $this->fareService->createOrUpdateFare($request->except('_token'));
                if ($ispageCreated) {
                    DB::commit();
                    return $this->responseJson(true, 200, 'Fare created successfully');
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack(false, 500, 'Something went wrong');
            }
        }
        $data['categories'] = $this->fareService->getCategories();
        return view('admin.fares.add', $data);
    }

    public function edit(Request $request){
        $this->setPageTitle('Edit Page');
        // $filterConditions= [
        //     'status'=> true
        // ];
        // $pageId= uuidtoid($uuid,'pages');
        // dd($request->all());
        $fareData= $this->fareService->findFareById($request->id);
        if($request->post()){
            DB::beginTransaction();
             try{
                $isfareUpdated= $this->fareService->createOrUpdateFare($request->except('_token'),$request->id);
                if($isfareUpdated){
                    DB::commit();
                    return $this->responseJson(true, 200, 'Fare updated successfully');
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack(false, 500, 'Something went wrong');
            }
        }
        return view('admin.fares.index',compact('fareData'));
    }
}
