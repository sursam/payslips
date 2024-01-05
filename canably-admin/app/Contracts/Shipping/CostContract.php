<?php

namespace App\Contracts\Shipping;

/**
 * Interface CostContract
 * @package App\Contracts
 */
interface CostContract
{
    public function listCosts(array $filterConditions, string $orderBy='id', string $sortBy='asc',$limit=null);

    public function addShippingCosts(array $attributes);
}
