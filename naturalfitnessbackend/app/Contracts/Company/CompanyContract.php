<?php

namespace App\Contracts\Company;

/**
 * Interface CompanyContract
 * @package App\Contracts
 */
interface CompanyContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCompanies(array $filterConditions,string $order = 'id', string $sort = 'desc', $limit= null,$inRandomOrder= false);



    /**
     * @param array $params
     * @return mixed
     */
    public function createCompany(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCompany(array $params,string $id);
}
