<?php

namespace App\Services\Category;
use App\Contracts\Category\CategoryContract;

class CategoryService
{
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;

	/**
     * CategoryService constructor
     */
    public function __construct(CategoryContract $categoryRepository){
        $this->categoryRepository= $categoryRepository;
    }

    public function getTotalData(array $filterConditions, $search=null){
        return $this->categoryRepository->getTotalData($filterConditions, $search);
    }

    public function getListofCategories(array $filterConditions,$start, $limit, $order, $dir, $search=null){
        return $this->categoryRepository->getListofCategories($filterConditions,$start, $limit, $order, $dir, $search);
    }
    public function categoriesList(array $filterConditions){
        return $this->categoryRepository->categoriesList($filterConditions);
    }
    public function getListofSubCategories(array $filterConditions){
        return $this->categoryRepository->getListofSubCategories($filterConditions);
    }
    public function listCategories(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->categoryRepository->findCategories($filterConditions,$orderBy,$sortBy,$limit);
    }
    public function listMasterCategories(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->categoryRepository->listMasterCategories($filterConditions,$orderBy,$sortBy,$limit);
    }
    public function listBrands(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->categoryRepository->listBrands($filterConditions,$orderBy,$sortBy,$limit);
    }

    public function attachAttributes(array $attributes, int $id){
        return $this->categoryRepository->attachAttributes($attributes,$id);
    }
    public function attachGroups(array $attributes, int $id){
        return $this->categoryRepository->attachGroups($attributes,$id);
    }

    public function getCategories(){
        return $this->categoryRepository->getCategories();
    }
    public function findCategoryById($id){
        return $this->categoryRepository->findCategoryById($id);
    }
    public function findCategoryBySlug($slug){
        return $this->categoryRepository->findCategoryBySlug($slug);
    }
    public function createOrUpdateCategory(array $attributes,$id= null){
        if(is_null($id)){
            return $this->categoryRepository->createCategory($attributes);
        }else{
            return $this->categoryRepository->updateCategory($attributes,$id);
        }
    }

    public function deleteCategory(int $id){
        return $this->categoryRepository->deleteCategory($id);
    }

    public function updateStatus(array $attributes,$id){
        return $this->categoryRepository->update($attributes,$id);
    }

    public function updateAttributeStatus(array $attributes, $id){
        $data['is_active']= $attributes['value'] == '1' ? 1 : 0;
        return $this->categoryRepository->updateAttributeStatus($data,$id);
    }
    public function listFaqCategories(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->categoryRepository->findFaqCategories($filterConditions,$orderBy,$sortBy,$limit);
    }
    public function listSupportCategories(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->categoryRepository->findSupportCategories($filterConditions,$orderBy,$sortBy,$limit);
    }
}
