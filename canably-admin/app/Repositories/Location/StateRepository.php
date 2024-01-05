<?php

namespace App\Repositories\Location;

use App\Models\State;
use App\Repositories\BaseRepository;
use App\Contracts\Location\StateContract;

class StateRepository extends BaseRepository implements StateContract
{

    protected $model;

    /**
     * StateRepository constructor
     *
     * @param State $model
     */
    public function __construct(State $model)
    {
        parent::__construct($model);
    }
}
