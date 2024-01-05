<?php

namespace App\Services\Shipping;

use App\Contracts\Shipping\CostContract;

class CostService
{
    protected $costRepository;

    public function __construct(CostContract $costRepository)
    {
        $this->costRepository = $costRepository;
    }

    public function getCostsList(array $filterConditions, string $orderBy='id', string $sortBy='asc',$limit=null){
        return $this->costRepository->listCosts($filterConditions,$orderBy, $sortBy,$limit);
    }

    public function addCosts(array $attributes){
        return $this->costRepository->addShippingCosts($attributes);
    }
    public function deleteCost(int $id){
        return $this->costRepository->delete($id);
    }
}
