<?php

namespace App\Repositories\Brand;

use App\Contracts\Brand\BrandContract;
use App\Models\Brand;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class BrandRepository
 *
 * @package \App\Repositories
 */
class BrandRepository extends BaseRepository implements BrandContract
{
    use UploadAble;

    protected $model;
    /**
     * BrandRepository constructor.
     * @param Brand $model
     * @param Media $mediaModel
     */
    public function __construct(Brand $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listBrands($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $brands = $this->model;
        if (!is_null($filterConditions)) {
            $brands = $brands->where($filterConditions);
        }
        $brands = $brands->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $brands->paginate($limit);
        }
        return $brands->get();
    }
    public function createBrand($attributes)
    {
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $isBrandCreated = $this->create($attributes);
        if ($isBrandCreated) {
            $isBrandCreated->seo()->create([
                'body' => $attributes['seo'],
            ]);
            if (isset($attributes['brand_image'])) {
                $fileName = uniqid() . '.' . $attributes['brand_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['brand_image'], config('constants.SITE_BRAND_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isBrandCreated->media()->create([
                        'user_id' => auth()->user()->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => false,
                    ]);
                }
            }
        }
        return $isBrandCreated;
    }

    public function updateBrand($attributes, $id)
    {
        $brandData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['slug'] = isSluggable($attributes['name']);
        $isBrandUpdated = $this->update($attributes, $id);
        if ($isBrandUpdated) {
            $brandData->seo()->updateOrCreate(['seoable_type'=>get_class($brandData),'seoable_id'=>$brandData->id],[
                'body' => $attributes['seo']
            ]);
            if (isset($attributes['brand_image'])) {
                $fileName = uniqid() . '.' . $attributes['brand_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['brand_image'], config('constants.SITE_BRAND_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $brandData->media()->updateOrCreate(['mediaable_id' => $id], [
                        'user_id' => auth()->user()->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => false,
                    ]);
                }
            }
        }
        return $isBrandUpdated;
    }

    public function deleteBrand($id)
    {
        $brandData = $this->find($id);
        $brandData->media()->delete();
        return $brandData->delete();
    }
}
