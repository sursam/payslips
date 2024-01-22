<?php

namespace App\Services\Page;
use App\Contracts\Page\PageContract;

class PageService
{
    /**
     * @var PageContract
     */
    protected $pageRepository;

	/**
     * UserService constructor
     */
    public function __construct(PageContract $pageRepository){
        $this->pageRepository= $pageRepository;
    }

    public function listPages(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
       // return $this->pageRepository->listPages($filterConditions,$orderBy,$sortBy,$limit);
        return $this->pageRepository->listPages($filterConditions,$orderBy,$sortBy,$limit);
    }

    public function getTotalData($search=null){
        return $this->pageRepository->getTotalData($search);
    }

    /**
     * Fetch individual Page by Slug
     * @param $slug
     * @return mixed
     */
    public function fetchPageBySlug($slug)
    {
        return $this->pageRepository->findPageBySlug($slug);

    }
    public function getListofPages($start, $limit, $order, $dir, $search=null){
        return $this->pageRepository->getList($start, $limit, $order, $dir, $search);
    }
    public function findPageById($id){
        return $this->pageRepository->findPageById($id);
    }

    public function updatePage(array $attributes,$id){
        return $this->pageRepository->update($attributes,$id);
    }

    public function createOrUpdatePage(array $attributes,$id= null){
        if(is_null($id)){
            return $this->pageRepository->createPage($attributes);
        }else{
            return $this->pageRepository->updatePage($attributes,$id);
        }
    }

    public function deletePage(int $id){
        return $this->pageRepository->deletePage($id);
    }
}
