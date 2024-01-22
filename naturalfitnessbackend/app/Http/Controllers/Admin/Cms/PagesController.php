<?php

namespace App\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use App\Services\Page\PageService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class PagesController extends BaseController
{

    public function __construct(protected PageService $pageService){
        $this->pageService= $pageService;
    }
    public function index(Request $request){
        $this->setPageTitle('List Pages');
        return view('admin.page.list');
    }
    public function add(Request $request){
        $this->setPageTitle('Add Page');
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
                'title' => 'required',
                "description" => 'required',
            ]);
            DB::beginTransaction();
            try {
                $ispageCreated = $this->pageService->createOrUpdatePage($request->except('_token'));
                if ($ispageCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.cms.page.list', 'Page created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.page.add');
    }
    public function edit(Request $request,$uuid){
        $this->setPageTitle('Edit Page');
        $filterConditions= [
            'status'=> true
        ];
        $pageId= uuidtoid($uuid,'pages');
        $pageData= $this->pageService->findPageById($pageId);
        if($request->post()){
            DB::beginTransaction();
             try{
                $ispageUpdated= $this->pageService->createOrUpdatePage($request->except('_token'),$pageId);
                if($ispageUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.cms.page.list','Page updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.page.edit',compact('pageData'));
    }
}
