<?php

namespace App\Contracts\Frontend;

/**
 * Interface ContactContract
 * @package App\Contracts
 */
interface ContactContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listContacts(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param array $params
     * @return mixed
     */
    public function createContact(array $params);

     /**
     * @param array $params
     * @return mixed
     */
    public function updateContactStatus(array $params);   
}