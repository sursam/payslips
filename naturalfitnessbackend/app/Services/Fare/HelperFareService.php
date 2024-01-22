<?php

namespace App\Services\Fare;

use App\Contracts\Fare\HelperFareContract;

class HelperFareService
{
    /**
     * @var HelperFareContract
     */
    protected $helperFareRepository;

	/**
     * UserService constructor
     */
    public function __construct(HelperFareContract $helperFareRepository){
        $this->helperFareRepository= $helperFareRepository;
    }

    public function listHelperFares(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
       // return $this->pageRepository->listPages($filterConditions,$orderBy,$sortBy,$limit);
        return $this->helperFareRepository->listHelperFares($filterConditions,$orderBy,$sortBy,$limit);
    }

    public function getTotalData($search=null){
        return $this->helperFareRepository->getTotalData($search);
    }

    /**
     * Fetch individual Page by Slug
     * @param $slug
     * @return mixed
     */
    public function fetchHelperFareBySlug($slug)
    {
        return $this->helperFareRepository->findHelperFareBySlug($slug);

    }
    public function getListofHelperFare($start, $limit, $order, $dir, $search=null){
        return $this->helperFareRepository->getList($start, $limit, $order, $dir, $search);
    }
    public function findHelperFareById($id){
        return $this->helperFareRepository->findHelperFareById($id);
    }

    public function updateHelperFare(array $attributes,$id){
        return $this->helperFareRepository->update($attributes,$id);
    }

    public function createOrUpdateHelperFare(array $attributes,$id= null){
        if(is_null($id)){
            return $this->helperFareRepository->createHelperFare($attributes);
        }else{
            return $this->helperFareRepository->updateHelperFare($attributes,$id);
        }
    }

    public function deleteHelperFare(int $id){
        return $this->helperFareRepository->deleteHelperFare($id);
    }

    public function getCategories(){
        return $this->helperFareRepository->getCategories();
    }
}
