<?php

namespace App\Services\Fare;

use App\Contracts\Fare\FareContract;

class FareService
{
    /**
     * @var FareContract
     */
    protected $fareRepository;

	/**
     * UserService constructor
     */
    public function __construct(FareContract $fareRepository){
        $this->fareRepository= $fareRepository;
    }

    public function listFares(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
       // return $this->pageRepository->listPages($filterConditions,$orderBy,$sortBy,$limit);
        return $this->fareRepository->listFares($filterConditions,$orderBy,$sortBy,$limit);
    }

    public function getTotalData($search=null){
        return $this->fareRepository->getTotalData($search);
    }

    /**
     * Fetch individual Page by Slug
     * @param $slug
     * @return mixed
     */
    public function fetchFareBySlug($slug)
    {
        return $this->fareRepository->findFareBySlug($slug);

    }
    public function getListofFare($start, $limit, $order, $dir, $search=null){
        return $this->fareRepository->getList($start, $limit, $order, $dir, $search);
    }
    public function findFareById($id){
        return $this->fareRepository->findFareById($id);
    }

    public function updateFare(array $attributes,$id){
        return $this->fareRepository->update($attributes,$id);
    }

    public function createOrUpdateFare(array $attributes,$id= null){
        if(is_null($id)){
            return $this->fareRepository->createFare($attributes);
        }else{
            return $this->fareRepository->updateFare($attributes,$id);
        }
    }

    public function deleteFare(int $id){
        return $this->fareRepository->deleteFare($id);
    }

    public function getCategories(){
        return $this->fareRepository->getCategories();
    }

    public function getFareBetweenTimes($time, array $filterConditions){
         return $this->fareRepository->getFareBetweenTimes($time, $filterConditions);
     }
}
