<?php

namespace App\Repositories\blog;

use App\Contracts\Blog\BlogContract;
use App\Models\Blog;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class BlogRepository
 *
 * @package \App\Repositories
 */
class BlogRepository extends BaseRepository implements BlogContract
{
    use UploadAble;

    protected $model;
    /**
     * BlogRepository constructor.
     * @param Blog $model
     */
    public function __construct(Blog $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listBlogs($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $blogs = $this->model;
        if (!is_null($filterConditions)) {
            $blogs = $blogs->where($filterConditions);
        }
        $blogs = $blogs->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $blogs->paginate($limit);
        }
        return $blogs->get();
    }
    public function createBlog($attributes)
    {
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['slug'] = isSluggable($attributes['title']);
        $isBlogCreated = $this->create($attributes);
        if ($isBlogCreated) {
            if (isset($attributes['blog_image'])) {
                $fileName = uniqid() . '.' . $attributes['blog_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['blog_image'], config('constants.SITE_BLOG_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isBlogCreated->media()->create([
                        'user_id' => auth()->user()->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                    ]);
                }
            }
            $isRelatedSeoCreated = $isBlogCreated->seo()->create([
                'body' => $attributes['seo'],
            ]);
        }
        return $isBlogCreated;
    }

    public function updateBlog($attributes, $id)
    {
        $blogData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['slug'] = isSluggable($attributes['title']);
        $isBlogUpdated = $this->update($attributes, $id);
        if ($isBlogUpdated) {
            if (isset($attributes['blog_image'])) {
                $fileName = uniqid() . '.' . $attributes['blog_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['blog_image'], config('constants.SITE_BLOG_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $blogData->media()->updateOrCreate(['mediaable_id' => $id], [
                        'user_id' => auth()->user()->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                    ]);
                }
            }
            $isRelatedSeoUpdated = $blogData->seo()->update([
                'body' => $attributes['seo'],
            ]);
        }
        return $isBlogUpdated;
    }

    public function deleteBlog($id)
    {
        $brandData = $this->find($id);
        $brandData->media()->delete();
        $brandData->seo()->delete();
        return $brandData->delete();
    }
}
