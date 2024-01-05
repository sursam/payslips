<?php

namespace App\Repositories\Location;

use App\Models\Country;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use App\Contracts\Location\CountryContract;

class CountryRepository extends BaseRepository implements CountryContract
{

    protected $model;

    /**
     * CountryRepository constructor
     *
     * @param Country $model
     */
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }

    /**
     * Find all country
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function findAll(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
}
