<?php

namespace App\Contracts\Fare;

/**
 * Interface FareContract
 * @package App\Contracts
 */
interface HelperFareContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listHelperFares(array $filterConditions,string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */

    public function findHelperFareById(int $id);

    /**
     * @param $slug
     * @return mixed
     */
    public function findHelperFareBySlug($slug);

    /**
     * @param array $params
     * @return mixed
     */
    public function createHelperFare(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateHelperFare(array $params,string $id);

    /**
     * @param $id
     * @return bool
     */
    public function deleteHelperFare($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateHelperFareStatus(array $params);

    public function findHelperFare(array $params);

    public function getCategories();
}
