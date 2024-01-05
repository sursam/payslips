<?php

namespace App\Contracts\Users;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface UserContract
{
	/**
     * @param $profileType
     * @param null $filterConditions
     * @param string $orderBy
     * @param string $sortBy
     * @param null $limit
     * @return mixed
     */
    public function findUsers($profileType, $filterConditions = null,
        $orderBy = 'id', $sortBy = 'desc', $limit = null);

    /**
     * Get all admin user
     *
     * @return mixed
     */
    public function getUsers(string $role);

    public function getAllUsers($filterConditions,$role,string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false);

    public function getCustomersDashboard(string $role,$filterConditions,$limit);

    public function getSellersDashboard(string $role,$filterConditions,$limit);

    public function getEmployeeUsers(string $role,string $type);


    /**
     * Create an admin
     *
     * @param array $params
     * @return mixed
     */
    public function createAdmin(array $params);

    public function createCustomer(array $attributes);

    public function registerCustomer(array $attributes);

    public function updateCustomer(array $attributes,int $id);

    public function createAgent(array $attributes);

    public function updateAgent(array $attributes,int $id);

}
