<?php

namespace App\Contracts\Role;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface RoleContract
{

    /**
     * @param null $search
     * @return mixed
     */
    public function getTotalData($search = null);

    /**
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getList($start, $limit, $order, $dir, $search=null);
    public function createRole(array $attributes);
}
