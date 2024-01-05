<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\Page\PageService;
use Illuminate\Support\Facades\Log;
use App\Services\Banner\BannerService;
use App\Http\Controllers\BaseController;

class BannerController extends BaseController
{

    protected $bannerService;
    protected $pageService;

    public function __construct(BannerService $bannerService , PageService $pageService) {
        $this->bannerService = $bannerService;
        $this->pageService = $pageService;
    }


    public function viewBanners() {
        $this->setPageTitle('All Banners');
        $filterConditions = [
            'is_active' => true
        ];
        $listBanners = $this->bannerService->listBanners($filterConditions, 'id', 'asc', 15);
        return view('admin.banner.list', compact('listBanners'));
    }

    public function addBanner(Request $request) {
        $this->setPageTitle('Add Banner');
        if ($request->post()) {

           $request->validate([
                'name' => 'required',
                "description" => 'required',
                'page'=> 'required|string',
                'position'=> 'required_if:page,home|string|nullable',
                // "link" => 'required_if:page,home|url|nullable',
                "order" => [Rule::requiredIf(function () use ($request) {
                    return $request->input('page') == 'home' && $request->input('postion') == 'top';
                }),'numeric'],
                "banner_image" => 'required|file|mimes:jpg,png,gif,jpeg',
            ]);
            \DB::beginTransaction();
            try{
                $isBannerCreated= $this->bannerService->createOrUpdateBanner($request->except('_token'));
                if($isBannerCreated){
                    \DB::commit();
                    return $this->responseRedirect('admin.banner.list','Banner created successfully','success',false);
                }
            }catch(\Exception $e){
                \DB::rollback();
                Log::channel('cms')->info($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        $pages= $this->pageService->listPages(['is_active'=>true], 'id', 'asc');
        return view('admin.banner.add-banner',compact('pages'));
    }

    public function editBanner(Request $request, $uuid){
        $this->setPageTitle('Edit Banner');
        $bannerId= uuidtoid($uuid,'banners');
        $bannerData= $this->bannerService->findBannerById($bannerId);
        $pages= $this->pageService->listPages(['is_active'=>true], 'id', 'asc');
        if($request->post()){
            $request->validate([
                'name' => 'required',
                // "link" => 'required|url',
                'page'=> 'required|string',
                'position'=> 'required_if:page,home|string|nullable',
                "description" => 'required',
                "order" => [Rule::requiredIf(function () use ($request) {
                    return $request->input('page') == 'home' && $request->input('postion') == 'top';
                }),'numeric'],
                "banner_image" => 'sometimes|file|mimes:jpg,png,gif,jpeg',
            ]);
            \DB::beginTransaction();
            try{
                $isBannerUpdated= $this->bannerService->createOrUpdateBanner($request->except('_token'),$bannerId);
                if($isBannerUpdated){
                    \DB::commit();
                    return $this->responseRedirect('admin.banner.list','Banner updated successfully','success',false);
                }
            }catch(\Exception $e){
                \DB::rollback();
                Log::channel('cms')->info($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }

        }
        return view('admin.banner.edit-banner',compact('bannerData','pages'));
    }


    public function deleteBanner($id)  {
        $bannerId =uuidtoid($id,'banners');
        \DB::beginTransaction();
        try{
            $isBannerDeleted= $this->bannerService->deleteBanner($bannerId);
            if($isBannerDeleted){
                \DB::commit();
                return $this->responseRedirect('admin.banner.list','Banner deleted successfully','success',false);
            }
        }catch(\Exception $e){
            \DB::rollback();
            Log::channel('cms')->info($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong','error',true);
        }
    }
}
