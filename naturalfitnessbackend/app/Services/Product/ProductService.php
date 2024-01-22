<?php

namespace App\Services\Product;
use App\Contracts\Product\ProductContract;

class ProductService
{
    protected $productRepository;
    public function __construct(ProductContract $productRepository)
    {
        $this->productRepository= $productRepository;
    }
    public function listServices(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->productRepository->listServices($filterConditions,$orderBy,$sortBy,$limit);
    }

    public function getTotalData($search=null){
        return $this->productRepository->getTotalData($search);
    }

    public function getListofServices($start, $limit, $order, $dir, $search=null){
        return $this->productRepository->getList($start, $limit, $order, $dir, $search);
    }
    public function findServiceById($id){
        return $this->productRepository->find($id);
    }

    public function updateService(array $attributes,$id){
        return $this->productRepository->update($attributes,$id);
    }

    public function createOrUpdateService(array $attributes,$id= null){
        if(is_null($id)){
            return $this->productRepository->create($attributes);
        }else{
            return $this->productRepository->update($attributes,$id);
        }
    }

    public function deleteService(int $id){
        return $this->productRepository->delete($id);
    }
}
