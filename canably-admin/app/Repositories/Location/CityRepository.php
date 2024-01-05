<?php

namespace App\Repositories\Location;

use App\Repositories\BaseRepository;
use App\Contracts\Location\CityContract;
use App\Models\City;

class CityRepository extends BaseRepository implements CityContract
{
    protected $model;

    /**
     * CityRepository constructor
     *
     * @param City $model
     */
    public function __construct(City $model)
    {
        parent::__construct($model);
    }
}
