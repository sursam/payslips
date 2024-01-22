<?php

namespace App\Http\Controllers\Driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Vehicle\VehicleService;

class DriverController extends Controller
{
    public function __construct(protected VehicleService $vehicleService){
        $this->vehicleService= $vehicleService;
    }
}
