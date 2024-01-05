<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class SiteSettingController extends BaseController
{
    public function __construct(){
        $this->setPageTitle('Site Settings');
    }

    public function index(Request $request){
        return view('admin.setting.index');
    }
}
