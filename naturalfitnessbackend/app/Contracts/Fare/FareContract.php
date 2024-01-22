<?php

namespace App\Contracts\Fare;

/**
 * Interface FareContract
 * @package App\Contracts
 */
interface FareContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listFares(array $filterConditions,string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */

    public function findFareById(int $id);

    /**
     * @param $slug
     * @return mixed
     */
    public function findFareBySlug($slug);

    /**
     * @param array $params
     * @return mixed
     */
    public function createFare(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateFare(array $params,string $id);

    /**
     * @param $id
     * @return bool
     */
    public function deleteFare($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateFareStatus(array $params);

    public function findFare(array $params);

    public function getCategories();
}
