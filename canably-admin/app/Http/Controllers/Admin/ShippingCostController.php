<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Location\CityService;
use App\Services\Shipping\CostService;
use App\Services\Location\StateService;
use App\Http\Controllers\BaseController;
use App\Services\Location\CountryService;

class ShippingCostController extends BaseController
{

    protected $costService;
    protected $countryService;
    protected $stateService;
    protected $cityService;

    public function __construct(CostService $costService,CountryService $countryService,StateService $stateService,CityService $cityService)
    {
        $this->costService = $costService;
        $this->countryService = $countryService;
        $this->stateService = $stateService;
        $this->cityService = $cityService;
    }

    public function index(Request $request){
        $this->setPageTitle('Shipping Costs');
        $filterConditions = [];
        $shippingCosts= $this->costService->getCostsList($filterConditions,'id','asc',15);
        return view('admin.shipping.cost.list',compact('shippingCosts'));
    }

    public function add(Request $request){
        $this->setPageTitle('Add Shipping Costs');
        $countryList= $this->countryService->getCountries();
        return view('admin.shipping.cost.add',compact('countryList'));
    }
}
