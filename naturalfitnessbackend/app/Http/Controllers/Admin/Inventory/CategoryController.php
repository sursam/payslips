<?php

namespace App\Http\Controllers\Admin\Inventory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Services\Category\CategoryService;
use App\Services\Group\GroupService;

class CategoryController extends BaseController
{
    public function __construct(protected CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request){
        $this->setPageTitle('List of Categories');
        return view('admin.inventories.category.list');
    }

    protected function addCategory($request, $validationRule, $redirectPath, $successMessage){
        $request->validate($validationRule);
        DB::beginTransaction();
        try {
            $isCategoryCreated = $this->categoryService->createOrUpdateCategory($request->except('_token'));
            if ($isCategoryCreated) {
                DB::commit();
                return $this->responseRedirect($redirectPath, $successMessage, 'success', false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }
    protected function editCategory($categoryId, $request, $validationRule, $redirectPath, $successMessage){
        $request->validate($validationRule);
        DB::beginTransaction();
        try {
            $isCategoryUpdated = $this->categoryService->createOrUpdateCategory($request->except('_token'),$categoryId);
            if ($isCategoryUpdated) {
                DB::commit();
                return $this->responseRedirect($redirectPath, $successMessage, 'success', false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }

    public function add(Request $request){
        $this->setPageTitle('Add Category');
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
                "image" => 'required|file|mimes:jpg,png,gif,jpeg',
            ];
            $redirectPath = 'admin.settings.categories.list';
            $successMessage = 'Business Types / Service Types created successfully';
            return $this->addCategory($request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.category.add');
    }
    public function edit(Request $request,$uuid){
        $this->setPageTitle('Edit Category');
        $categoryId = uuidtoid($uuid, 'categories');
        $categoryData = $this->categoryService->findCategoryById($categoryId);
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
                "image" => 'sometimes|file|mimes:jpg,png,gif,jpeg',
            ];
            $redirectPath = 'admin.settings.categories.list';
            $successMessage = 'Business Types / Service Types updated successfully';
            return $this->editCategory($categoryId, $request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.category.edit',compact('categoryData'));
    }

    public function listObjectives(Request $request){
        $this->setPageTitle('List of Objectives');
        return view('admin.inventories.objective.list');
    }

    public function addObjective(Request $request){
        $this->setPageTitle('Add Objective');
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
                "image" => 'required|file|mimes:jpg,png,gif,jpeg',
            ];
            $redirectPath = 'admin.settings.objectives.list';
            $successMessage = 'Objective created successfully';
            return $this->addCategory($request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.objective.add');
    }
    public function editObjective(Request $request,$uuid){
        $this->setPageTitle('Edit Objective');
        $categoryId = uuidtoid($uuid, 'categories');
        $categoryData = $this->categoryService->findCategoryById($categoryId);
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
                "image" => 'sometimes|file|mimes:jpg,png,gif,jpeg',
            ];
            $redirectPath = 'admin.settings.objectives.list';
            $successMessage = 'Objective updated successfully';
            return $this->editCategory($categoryId, $request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.objective.edit',compact('categoryData'));
    }

    public function listEligibilities(Request $request){
        $this->setPageTitle('List of Eligibilities');
        return view('admin.inventories.eligibility.list');
    }
    public function addEligibility(Request $request){
        $this->setPageTitle('Add Eligibility');
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
            ];
            $redirectPath = 'admin.settings.eligibilities.list';
            $successMessage = 'Eligibility created successfully';
            return $this->addCategory($request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.eligibility.add');
    }
    public function editEligibility(Request $request,$uuid){
        $this->setPageTitle('Edit Eligibility');
        $categoryId = uuidtoid($uuid, 'categories');
        $categoryData = $this->categoryService->findCategoryById($categoryId);
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
            ];
            $redirectPath = 'admin.settings.eligibilities.list';
            $successMessage = 'Eligibility updated successfully';
            return $this->editCategory($categoryId, $request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.eligibility.edit',compact('categoryData'));
    }

    public function listDocuments(Request $request){
        $this->setPageTitle('List of Documents');
        return view('admin.inventories.document.list');
    }
    public function addDocument(Request $request){
        $this->setPageTitle('Add Document');
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
            ];
            $redirectPath = 'admin.settings.documents.list';
            $successMessage = 'Document created successfully';
            return $this->addCategory($request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.document.add');
    }
    public function editDocument(Request $request,$uuid){
        $this->setPageTitle('Edit Document');
        $categoryId = uuidtoid($uuid, 'categories');
        $categoryData = $this->categoryService->findCategoryById($categoryId);
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
            ];
            $redirectPath = 'admin.settings.documents.list';
            $successMessage = 'Document updated successfully';
            return $this->editCategory($categoryId, $request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.document.edit',compact('categoryData'));
    }

    public function referralTypes(Request $request){
        $this->setPageTitle('List of Referral Types');
        return view('admin.inventories.referral_type.list');
    }
    public function addReferralType(Request $request){
        $this->setPageTitle('Add Referral Type');
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
            ];
            $redirectPath = 'admin.referral.type.list';
            $successMessage = 'Referral Type created successfully';
            return $this->addCategory($request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.referral_type.add');
    }
    public function editReferralType(Request $request,$uuid){
        $this->setPageTitle('Edit Referral Type');
        $categoryId = uuidtoid($uuid, 'categories');
        $categoryData = $this->categoryService->findCategoryById($categoryId);
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
            ];
            $redirectPath = 'admin.referral.type.list';
            $successMessage = 'Referral Type updated successfully';
            return $this->editCategory($categoryId, $request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.referral_type.edit',compact('categoryData'));
    }
    public function listLevels(Request $request){
        $this->setPageTitle("List of Doctor's Levels");
        return view('admin.inventories.doctor_level.list');
    }
    public function addLevel(Request $request){
        $this->setPageTitle("Add Doctor's Level");
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
            ];
            $redirectPath = 'admin.medical.doctor.level.list';
            $successMessage = 'Level created successfully';
            return $this->addCategory($request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.doctor_level.add');
    }
    public function editLevel(Request $request,$uuid){
        $this->setPageTitle("Edit Doctor's Level");
        $categoryId = uuidtoid($uuid, 'categories');
        $categoryData = $this->categoryService->findCategoryById($categoryId);
        if ($request->post()) {
            $validationRule = [
                'name' => 'required',
            ];
            $redirectPath = 'admin.medical.doctor.level.list';
            $successMessage = 'Level updated successfully';
            return $this->editCategory($categoryId, $request, $validationRule, $redirectPath, $successMessage);
        }
        return view('admin.inventories.doctor_level.edit', compact('categoryData'));
    }
}
