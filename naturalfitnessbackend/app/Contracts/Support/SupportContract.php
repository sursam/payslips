<?php

namespace App\Contracts\Support;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface SupportContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listSupports(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createSupport(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateSupport(array $attributes, int $id);

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */

     public function findSupportById(int $id);
}
