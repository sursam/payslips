<?php

namespace App\Repositories\Content;

use App\Contracts\Content\ContentContract;
use App\Models\Content;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class BlogRepository
 *
 * @package \App\Repositories
 */
class ContentRepository extends BaseRepository implements ContentContract
{
    use UploadAble;

    protected $model;
    /**
     * BlogRepository constructor.
     * @param Content $model
     */
    public function __construct(Content $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listContents($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $blogs = $this->model;
        if (!is_null($filterConditions)) {
            foreach ($filterConditions as $fKey => $fCondition) {
                if ($fKey == 'search') {
                    $blogs = $blogs->where('title', 'LIKE', "%$fCondition%")
                        ->orWhere('slug', 'LIKE', "%$fCondition%");
                } else {
                    $blogs = $blogs->where($fKey, $fCondition);
                }
            }
        }
        $blogs = $blogs->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $blogs->paginate($limit);
        }
        return $blogs->get();
    }
    public function createContent($attributes)
    {
        $isBlogCreated = $this->create($attributes);
        if ($isBlogCreated) {
            if (isset($attributes['content_image'])) {
                $fileName = uniqid() . '.' . $attributes['content_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['content_image'], config('constants.SITE_CONTENT_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isBlogCreated->media()->create([
                        'user_id' => auth()->user()->id,
                        'mediaable_type' => get_class($isBlogCreated),
                        'mediaable_id' => $isBlogCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                    ]);
                }
            }
        }
        return $isBlogCreated;
    }

    public function updateContent($attributes, $id)
    {
        $blogData = $this->find($id);
        $isBlogUpdated = $this->update($attributes, $id);
        if ($isBlogUpdated) {
            if (isset($attributes['content_image'])) {
                $fileName = uniqid() . '.' . $attributes['content_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['content_image'], config('constants.SITE_CONTENT_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $blogData->media()->updateOrCreate(['mediaable_id' => $id], [
                        'user_id' => auth()->user()->id,
                        'mediaable_type' => get_class($blogData),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                    ]);
                }
            }

        }
        return $isBlogUpdated;
    }

    public function deleteContent($id)
    {
        $brandData = $this->find($id);
        $brandData->media()->delete();
        $brandData->seo()->delete();
        return $brandData->delete();
    }
}
