<?php

namespace App\Contracts\Category;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface CategoryContract
{


    public function findCategories($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false);
    public function getListofCategories(array $filterConditions,$start, $limit, $order, $dir, $search = null);
    public function categoriesList(array $filterConditions);
    public function getListofSubCategories(array $filterConditions);
    public function listMasterCategories(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false);

    public function getTotalData(array $filterConditions,$search= null);
    public function getCategories();

    public function findCategoryById(int $id);

    public function createCategory(array $attributes);

    public function updateCategory(array $attributes,int $id);

    public function deleteCategory(int $id);

    public function setCategoryStatus(array $data,int $id);
    public function findSupportCategories($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false);
    public function findFaqCategories($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false);
}
