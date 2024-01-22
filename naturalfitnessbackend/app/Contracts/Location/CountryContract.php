<?php

namespace App\Contracts\Location;

/**
 * Interface CountryContract
 * @package App\Contracts
 */
interface CountryContract
{
    public function findAll(string $order = 'id', string $sort = 'desc', array $columns = ['*']);
}
