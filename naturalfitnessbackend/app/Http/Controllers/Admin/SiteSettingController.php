<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class SiteSettingController extends BaseController
{
    public function __construct(){
        $this->setPageTitle('Site Settings');
    }

    public function index(Request $request){
        if($request->post()){
            $data= $request->except('_token');
            DB::beginTransaction();
            try{
                foreach ($data as $key => $value) {
                    Setting::updateOrCreate(['key'=>$key],[
                        'value' => $value
                    ]);
                }
                DB::commit();
                return $this->responseRedirectBack('Settings updated successfully', 'success', false);
            }catch(\Exception $e){
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }
        }
        return view('admin.settings.site-settings.index');
    }
}
