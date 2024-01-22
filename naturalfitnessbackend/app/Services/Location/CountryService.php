<?php

namespace App\Services\Location;

use App\Contracts\Location\CountryContract;

class CountryService
{
    /**
     * @var CountryContract
     */
    protected $countryRepository;

    /**
     * CountryService constructor
     */
    public function __construct(CountryContract $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getCountries(){
        return $this->countryRepository->findAll();
    }

}
