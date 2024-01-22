<?php

namespace App\Services\Frontend;

use App\Contracts\Frontend\ContactContract;

class ContactService
{
    protected $contactRepository;

    /**
     * ContactService constructor
     *
     * @param ContactContract $contactRepository
     */
    public function __construct(contactContract $contactRepository){
        $this->contactRepository = $contactRepository;
    }


    /**
     * Fetch individual Contract
     *
     * @param int $id
     * @return mixed
     */
    public function fetchContactById($id) {
        return $this->contactRepository->find($id);
    }

    /**
     * Fetch List of Contract
     * @return mixed
     */
    public function fetchContacts() {
        return $this->contactRepository->listContacts();
    }

    /**
     * Save Contract information
     * @param array $params
     * @return mixed
     */
    public function createContact(array $params) {
        $params['status'] = (isset($params['status']) && !is_null($params['status'])) ? true : false;
        return $this->contactRepository->createContact($params);
    }

    /**
     * Update status of a Contract
     * @param int $id
     * @return mixed
     */
    public function updateContactStatus($id,$checkStatus){
        $params = array("id"=>$id,"check_status"=>$checkStatus);
        return $this->contactRepository->updateContractStatus($params);
    }

    /**
     * list of Contract
     *
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getList($start, $limit, $order, $dir, $search=null){
        return $this->contactRepository->getList($start, $limit, $order, $dir, $search);
    }

    /**
     * count of contacts
     *
     * @param null $search
     * @return mixed
     */
    public function getTotalData($search=null){
        return $this->contactRepository->getTotalData($search);
    }
}
