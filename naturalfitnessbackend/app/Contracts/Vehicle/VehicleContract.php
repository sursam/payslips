<?php

namespace App\Contracts\Vehicle;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface VehicleContract
{
	/**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listVehicles(array $filterConditions,string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */

    public function findVehicleById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createVehicle(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateVehicle(array $params,string $id);

    /**
     * @param $id
     * @return bool
     */
    public function deleteVehicle($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateVehicleStatus(array $params);

    public function findVehicle(array $params);
}
