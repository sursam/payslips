<?php

namespace App\Services\Location;

use App\Contracts\Location\StateContract;

class StateService
{
    /**
     * @var StateContract
     */
    protected $stateRepository;

    /**
     * StateService constructor
     */
    public function __construct(StateContract $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function findState(int $id){
        return $this->stateRepository->find($id);
    }
}
