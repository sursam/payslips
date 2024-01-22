<?php

namespace App\Http\Controllers\Admin\Support;

use Illuminate\Http\Request;
use App\Services\Faq\FaqService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Services\Category\CategoryService;

class FaqController extends BaseController
{
    public function __construct(protected FaqService $faqService, protected CategoryService $categoryService){
        $this->faqService= $faqService;
        $this->categoryService= $categoryService;
    }
    public function index(Request $request){
        $this->setPageTitle("List FAQ's");
        $categories = $this->categoryService->listFaqCategories([]);
        return view('admin.faq.list', compact('categories'));
    }
    public function add(Request $request){
        $this->setPageTitle('Add Faq');
        if ($request->post()) {
            $request->validate([
                'category_id' => 'required|string|exists:categories,id',
                'question' => 'required|string',
                "answer" => 'required|string'
            ]);
            DB::beginTransaction();
            try {
                $isfaqCreated = $this->faqService->createOrUpdateFaq($request->except('_token'));
                if ($isfaqCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.cms.faq.list', 'FAQ created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack(false, 500, 'Something went wrong');
            }
        }
        $categories = $this->categoryService->listFaqCategories([]);
        return view('admin.faq.add', compact('categories'));
    }
    public function edit(Request $request,$uuid){
        $this->setPageTitle('Edit FAQ');
        $filterConditions= [
            'status'=> true
        ];
        $faqId= uuidtoid($uuid,'faqs');
        $faqData= $this->faqService->findFaqById($faqId);
        // dd($faqData);
        if($request->post()){
            DB::beginTransaction();
             try{
                $isfaqUpdated= $this->faqService->createOrUpdateFaq($request->except('_token'),$faqId);
                if($isfaqUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.cms.faq.list','FAQ updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        $categories = $this->categoryService->listFaqCategories([]);
        return view('admin.faq.edit',compact('faqData', 'categories'));
    }

    public function addFaqGroup(Request $request){
        $this->setPageTitle("Add FAQ's Group");
        if ($request->post()) {
            $request->validate([
                'name' => 'required|string',
            ]);
            DB::beginTransaction();
            try {
                $isFaqGroupCreated = $this->categoryService->createOrUpdateCategory($request->except('_token'));
                if ($isFaqGroupCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.cms.faq.list', 'FAQ group created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack(false, 500, 'Something went wrong');
            }
        }
        return view('admin.faq.add-group');
    }
    public function editFaqGroup(Request $request,$uuid){
        $this->setPageTitle("Edit FAQ's Group");
        $faqGroupId= uuidtoid($uuid,'categories');
        $faqGroupData= $this->categoryService->findCategoryById($faqGroupId);
        if($request->post()){
            $request->validate([
                'name' => 'required|string',
            ]);
            DB::beginTransaction();
             try{
                $isFaqGroupUpdated = $this->categoryService->createOrUpdateCategory($request->except('_token'), $faqGroupId);
                if($isFaqGroupUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.cms.faq.list','FAQ group updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.faq.edit-group',compact('faqGroupData'));
    }
}
