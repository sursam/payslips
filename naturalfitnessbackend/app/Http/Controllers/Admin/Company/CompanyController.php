<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{
    public function index(Request $request){
        return view('admin.companies.index');
    }
}
