<?php

namespace App\Services\Location;

use App\Contracts\Location\CityContract;

class CityService
{
    /**
     * @var CityContract
     */
    protected $cityRepository;

    /**
     * CityService constructor
     */
    public function __construct(CityContract $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }
}
