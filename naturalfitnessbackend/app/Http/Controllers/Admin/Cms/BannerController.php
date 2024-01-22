<?php

namespace App\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Banner\BannerService;
use App\Http\Controllers\BaseController;

class BannerController extends BaseController
{

    public function __construct(protected BannerService $bannerService) {
        $this->bannerService = $bannerService;
    }


    public function index() {
        $this->setPageTitle('All Banners');
        return view('admin.banner.list');
    }

    public function add(Request $request) {
        $this->setPageTitle('Add Banner');
        if ($request->post()) {
           $request->validate([
                'link' => 'required',
                'text' => 'required|string|min:10',
                "order" => 'required|numeric|unique:banners,order',
                "banner_image" => 'required|file|mimes:jpg,png,gif,jpeg',
            ]);
            DB::beginTransaction();
            try{
                $isBannerCreated= $this->bannerService->createOrUpdateBanner($request->except('_token'));
                if($isBannerCreated){
                    DB::commit();
                    return $this->responseRedirect('admin.cms.banner.list','Banner created successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.banner.add');
    }

    public function edit(Request $request, $uuid){
        $this->setPageTitle('Edit Banner');
        $bannerId= uuidtoid($uuid,'banners');
        $bannerData= $this->bannerService->findBannerById($bannerId);
        if($request->post()){
            $request->validate([
                // 'name' => 'required',
                // "description" => 'required',
                'link' => 'required',
                "order" => 'required|numeric|unique:banners,order,'.$bannerData->id,
                "banner_image" => 'sometimes|file|mimes:jpg,png,gif,jpeg',
            ]);
            DB::beginTransaction();
            try{
                $isBannerUpdated= $this->bannerService->createOrUpdateBanner($request->except('_token'),$bannerId);
                if($isBannerUpdated){
                    // dd($isBannerUpdated);
                    DB::commit();
                    return $this->responseRedirect('admin.cms.banner.list','Banner updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }

        }
        return view('admin.banner.edit',compact('bannerData'));
    }


    public function delete($id)  {
        $bannerId =uuidtoid($id,'banners');
        DB::beginTransaction();
        try{
            $isBannerDeleted= $this->bannerService->deleteBanner($bannerId);
            if($isBannerDeleted){
                DB::commit();
                return $this->responseRedirect('admin.banner.list','Banner deleted successfully','success',false);
            }
        }catch(\Exception $e){
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong','error',true);
        }
    }
}
