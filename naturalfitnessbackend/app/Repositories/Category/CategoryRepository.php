<?php

namespace App\Repositories\Category;

use App\Models\Site\Group;
use App\Traits\UploadAble;
use App\Models\Site\Category;
use App\Models\Site\Attribute;
use App\Repositories\BaseRepository;
use App\Contracts\Category\CategoryContract;

/**
 * Class UserRepository
 *
 * @package \App\Repositories
 */
class CategoryRepository extends BaseRepository implements CategoryContract
{
    use UploadAble;
    /**
     * CategoryRepository constructor.
     * @param Category $model
     *  @param Attribute $attributeModel
     */
    public function __construct(Category $model,protected Attribute $attributeModel,protected Group $groupModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->attributeModel = $attributeModel;
        $this->groupModel = $groupModel;
    }

    public function getTotalData($filterConditions, $search=null){
        $query = $this->model;
        if($filterConditions) {
            $query = $query->where($filterConditions);
        }
        if($search) {
            $query = $query->where('name','LIKE',"%{$search}%");
        }
        return $query->count();
    }
    public function getListofCategories($filterConditions, $start, $limit, $order, $dir, $search = null)
    {
        $query = $this->model->where($filterConditions);
        if($search) {
            $query = $query->where('name','LIKE',"%{$search}%");
        }
        return $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    }
    public function categoriesList($filterConditions)
    {
        $query = $this->model->where($filterConditions);
        return $query->orderBy('id', 'asc')->get();
    }
    public function getListofSubCategories($filterConditions)
    {
        $query = $this->model->whereNull('parent_id')->where($filterConditions);
        return $query->orderBy('id', 'desc')->get();
    }

    public function findCategories($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $categories = $this->model->where($filterConditions)->orderBy($orderBy,$sortBy);
        if (!is_null($limit)) {
            return $categories->paginate($limit);
        }
        // dd($categories->with('subCategory')->get());
        return $categories->with('subCategory')->get();
    }
    public function listMasterCategories($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $categories = $this->model->whereNull('parent_id')->get();
        return $categories;
    }
    public function findAttributes($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $attribute = $this->attributeModel;

        if (!is_null($filterConditions)) {
            $attribute= $attribute->where($filterConditions);
        }

        $attribute= $attribute->orderBy($orderBy,$sortBy);
        if (!is_null($limit)) {
            return $attribute->paginate($limit);
        }
        return $attribute->get();
    }
    public function getCategories()
    {
        return $this->with('subcategories')->where(['parent_id' => 0])->get();
        // return $this->all();
    }
    public function findCategoryById($id)
    {
        return $this->find($id);
    }
    public function findCategoryBySlug($slug)
    {
        return $this->model->where(['slug' => $slug, 'type' => 'vehicle'])->first();
    }
    public function createCategory($attributes)
    {
        if(isset($attributes['category_id'])){
            $isCategoryCreated = $this->create([
                'name' => $attributes['name'],
                'parent_id' => $attributes['category_id'],
                'type' => $attributes['type']
            ]);
            if ($isCategoryCreated) {
                if (isset($attributes['image'])) {
                    $fileName = uniqid() . '.' . $attributes['image']->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($attributes['image'], config('constants.SITE_CATEGORY_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $isCategoryCreated->image()->create([
                            'user_id' => auth()->user()->id,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'alt_text' => $attributes['alt_text'] ?? null,
                            'is_profile_picture' => false,
                        ]);
                    }
                }
            }
        }else{
            $isCategoryCreated = $this->create([
                'name' => $attributes['name'],
                'type' => $attributes['type']
            ]);
            if ($isCategoryCreated) {
                if (isset($attributes['image'])) {
                    $fileName = uniqid() . '.' . $attributes['image']->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($attributes['image'], config('constants.SITE_CATEGORY_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $isCategoryCreated->image()->create([
                            'user_id' => auth()->user()->id,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'alt_text' => $attributes['alt_text'] ?? null,
                            'is_profile_picture' => false,
                        ]);
                    }
                }
            }
        }
        return $isCategoryCreated;
    }
    public function updateCategory($attributes, $id)
    {
        $categoryData = $this->find($id);
        $isCategoryUpdated = $this->update([
            'name' => $attributes['name'],
            'type' => $attributes['type']
        ], $id);
        if($isCategoryUpdated) {
            if (isset($attributes['image'])) {
                $fileName = uniqid() . '.' . $attributes['image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['image'], config('constants.SITE_CATEGORY_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $categoryData->image()->updateOrCreate(['mediaable_id' => $id], [
                        'user_id' => auth()->user()->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                    ]);
                }
            }
        }
        return $isCategoryUpdated;
    }
    public function setCategoryStatus($attributes, $id)
    {
        return $this->update($attributes, $id);
    }
    public function deleteCategory($id)
    {
        $category = $this->findCategoryById($id);
        ## Delete page seo
        if ($category) {
            $category->seo?->delete();
            $category->delete();
        }
        return $category ?? false;
    }
    public function listAttributes($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $attribute = $this->attributeModel->get();
        if (!is_null($limit)) {
            return $attribute->paginate($limit);
        }
        return $attribute;
    }
    public function findAttributeById($id)
    {
        return $this->attributeModel->find($id);
    }
    public function createAttribute($attributes)
    {
        $isAttributCreated = $this->attributeModel->create([
            'name' => $attributes['name']
        ]);
        if ($isAttributCreated->id) {
            foreach ($attributes['category']  as $cat_id) {
                $category = $this->find($cat_id);
                $isAttributeAttached = $category->attribute()->attach($isAttributCreated);
            }
        }
        return $isAttributCreated;
    }
    public function createAttributeValue($attributes)
    {
        return $this->attributeValueModel->create([
            'value' => $attributes['value'],
            'attribute_id' => $attributes['attribute_id'],
        ]);
    }





    public function attachAttributes(array $attributes,int $id){
        $category= $this->find($id);
        if($category){
            if(isset($attributes['attributes'])){
                $attributes= $this->attributeModel->whereIn('uuid',$attributes['attributes'])->get();
                $category->attributes()->sync($attributes);
            }
            return $category;
        }
        return false;
    }
    public function attachGroups(array $attributes,int $id){
        $category= $this->find($id);
        if($category){
            if(isset($attributes['attributes'])){
                $attributes= $this->groupModel->whereIn('uuid',$attributes['attributes'])->get();
                $category->groups()->sync($attributes);
            }
            return $category;
        }
        return false;
    }

    public function findFaqCategories($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $categories = $this->model->where('type', 'faqs')->where($filterConditions)->orderBy($orderBy,$sortBy);
        if (!is_null($limit)) {
            return $categories->paginate($limit);
        }
        return $categories->with('faqs')->get();
    }
    public function findSupportCategories($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $categories = $this->model->where('type', 'support')->where('parent_id', NULL)->where($filterConditions)->orderBy($orderBy,$sortBy);
        if (!is_null($limit)) {
            return $categories->paginate($limit);
        }
        // return $categories->with('supports')->get();
        return $categories->get();
    }


}
