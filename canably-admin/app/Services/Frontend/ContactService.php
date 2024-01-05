<?php

namespace App\Services\Frontend;

use App\Contracts\Frontend\ContactContract;
use Illuminate\Support\Facades\Hash;

class ContactService
{
    protected $contactRepository;

    /**
     * ContactService constructor
     *
     * @param ContractContract $contactRepository
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
     * @param Array $params
     * @return mixed
     */
    public function createContact($params) {
        $params['status'] = (isset($params['status']) && !is_null($params['status'])) ? true : false;
        return $this->contactRepository->createContact($params);
    }

    /**
     * Update status of a Contract
     * @param int $id
     * @return mixed
     */
    public function updateContactStatus($id,$check_status){
        $params = array("id"=>$id,"check_status"=>$check_status);
        $contract = $this->contactRepository->updateContractStatus($params);

        return $contract;
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
