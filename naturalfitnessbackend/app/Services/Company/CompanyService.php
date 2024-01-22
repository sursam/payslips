<?php

namespace App\Services\Company;
use App\Contracts\Company\CompanyContract;

class CompanyService
{
    /**
     * @var CompanyContract
     */
    protected $companyRepository;

	/**
     * CompanyService constructor
     */
    public function __construct(CompanyContract $companyRepository){
        $this->companyRepository= $companyRepository;
    }

    public function listCompanies(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->companyRepository->listCompanies($filterConditions,$orderBy,$sortBy,$limit,$inRandomOrder);
    }

    public function getTotalData($search=null){
        return $this->companyRepository->getTotalData($search);
    }


    public function getListofCompanies($start, $limit, $order, $dir, $search=null){
        return $this->companyRepository->getList($start, $limit, $order, $dir, $search);
    }
    public function findById(int $id){
        return $this->companyRepository->find($id);
    }

    public function updateCompany(array $attributes,int $id){
        return $this->companyRepository->update($attributes,$id);
    }

    public function createOrUpdateCompany(array $attributes,$id= null){
        if(is_null($id)){
            return $this->companyRepository->createCompany($attributes);
        }else{
            return $this->companyRepository->updateCompany($attributes,$id);
        }
    }

    public function delete(int $id){
        return $this->companyRepository->delete($id);
    }

    public function addLocation(array $attributes, $id){
        return $this->companyRepository->createLocation($attributes, $id);
    }
}
