<?php

namespace App\Http\Controllers\Admin\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Services\Support\SupportService;
use App\Services\Category\CategoryService;

class SupportController extends BaseController
{
    public function __construct(protected SupportService $supportService, protected CategoryService $categoryService){
        $this->supportService= $supportService;
        $this->categoryService= $categoryService;
    }
    public function index(Request $request){
        $this->setPageTitle("List Support Type");
        // $categories = $this->categoryService->listSupportCategories([]);
        $filterConditions = [
            'type' => 'support'
        ];
        $totalData = $this->categoryService->getTotalData($filterConditions);
        $totalFiltered = $totalData;
        $limit = 10;
        $start = 0;
        $order = 'id';
        $dir = 'asc';
        $index = $start;
        $nestedData = [];
        $data = [];
        $categories = $this->categoryService->getListofCategories($filterConditions, $start, $limit, $order, $dir);
        return view('admin.support.list', compact('categories'));
    }
    public function add(Request $request){
        $this->setPageTitle('Add Support');
        if ($request->post()) {
            $request->validate([
                'category_id' => 'required|string|exists:categories,id',
                'name' => 'required|string',
            ]);
            DB::beginTransaction();
            try {
                $isSupportCreated = $this->categoryService->createOrUpdateCategory($request->except('_token'));
                if ($isSupportCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.support.support.list', 'Support created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack(false, 500, 'Something went wrong');
            }
        }
        $categories = $this->categoryService->listSupportCategories([]);
        return view('admin.support.add', compact('categories'));
    }
    // public function edit(Request $request,$uuid){
    //     $this->setPageTitle('Edit Support');
    //     $filterConditions= [
    //         'status'=> true
    //     ];
    //     $supportId= uuidtoid($uuid,'supports');
    //     $supportData= $this->supportService->findSupportById($supportId);
    //     if($request->post()){
    //         DB::beginTransaction();
    //          try{
    //             $issupportUpdated= $this->supportService->createOrUpdateSupport($request->except('_token'),$supportId);
    //             if($issupportUpdated){
    //                 DB::commit();
    //                 return $this->responseRedirect('admin.support.support.list','Support updated successfully','success',false);
    //             }
    //         }catch(\Exception $e){
    //             DB::rollback();
    //             logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
    //             return $this->responseRedirectBack('Something went wrong','error',true);
    //         }
    //     }
    //     $categories = $this->categoryService->listSupportCategories([]);
    //     return view('admin.support.edit',compact('supportData', 'categories'));
    // }

    public function edit(Request $request,$uuid){
        $this->setPageTitle('Edit Support Type');
        $filterConditions= [
            'status'=> true
        ];
        $supportId= uuidtoid($uuid,'categories');
        $supportData= $this->categoryService->findCategoryById($supportId);
        if($request->post()){
            DB::beginTransaction();
             try{
                $request->merge(['type' => 'support']);
                $issupportUpdated= $this->categoryService->createOrUpdateCategory($request->except('_token'),$supportId);
                if($issupportUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.support.support.list','Support type updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        $categories = $this->categoryService->listSupportCategories([]);
        return view('admin.support.edit',compact('supportData', 'categories'));
    }

    public function addSupportGroup(Request $request){
        $this->setPageTitle('Add Support Type');
        if ($request->post()) {
            $request->validate([
                'name' => 'required|string',
            ]);
            DB::beginTransaction();
            try {
                $isSupportCreated = $this->categoryService->createOrUpdateCategory($request->except('_token'));
                if ($isSupportCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.support.support.list', 'Support type created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack(false, 500, 'Something went wrong');
            }
        }
        $categories = $this->categoryService->listSupportCategories([]);
        return view('admin.support.add-group', compact('categories'));
    }
}
