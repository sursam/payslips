<?php

namespace App\Services\Content;
use App\Contracts\Content\ContentContract;

class ContentService
{
    /**
     * @var ContentContract
     */
    protected $contentRepository;

	/**
     * BlogService constructor
     */
    public function __construct(ContentContract $contentRepository){
        $this->contentRepository= $contentRepository;
    }
    public function listContents(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->contentRepository->listContents($filterConditions,$orderBy,$sortBy,$limit,$inRandomOrder);
    }
    public function findContentById($id){
        return $this->contentRepository->find($id);
    }

    public function createOrUpdateContent(array $attributes, $id = null){
        if (is_null($id)) {
            return $this->contentRepository->createContent($attributes);
        } else {
            return $this->contentRepository->updateContent($attributes, $id);
        }
    }
    public function updateContentStatus($attributes,$id){
        $attributes['is_active']= $attributes['value'] == '1' ? 1 : 0;
        return $this->contentRepository->update($attributes, $id);
    }

    public function deleteContent(int $id){
        return $this->contentRepository->deleteContent($id);
    }
}
