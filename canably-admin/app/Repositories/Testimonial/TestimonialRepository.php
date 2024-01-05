<?php

namespace App\Repositories\Testimonial;

use App\Contracts\Testimonial\TestimonialContract;
use App\Models\Testimonial;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class TestimonialRepository
 *
 * @package \App\Repositories
 */
class TestimonialRepository extends BaseRepository implements TestimonialContract
{
    use UploadAble;

    protected $model;
    /**
     * BlogRepository constructor.
     * @param Testimonial $model
     */
    public function __construct(Testimonial $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listTestimonials($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $testimonials = $this->model;
        if (!is_null($filterConditions)) {
            $testimonials = $testimonials->where($filterConditions);
        }
        $testimonials = $testimonials->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $testimonials->paginate($limit);
        }
        return $testimonials->get();
    }
    public function createTestimonial($attributes)
    {
        $isTestimonialCreated= $this->create($attributes);
        if($isTestimonialCreated){
            if(isset($attributes['testimonial_image'])){
                $fileName = uniqid() . '.' . $attributes['testimonial_image']->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($attributes['testimonial_image'], config('constants.SITE_PRODUCT_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $isTestimonialCreated->media()->create([
                            'user_id' => auth()->user()->id,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'is_profile_picture' => false
                        ]);
                    }
            }
        }
        return $isTestimonialCreated;
    }

    public function updateTestimonial($attributes, $id)
    {
        $testimonialData = $this->find($id);
        $isTestimonialUpdated= $this->update($attributes,$id);
        if($isTestimonialUpdated){
            if(isset($attributes['testimonial_image'])){
                $fileName = uniqid() . '.' . $attributes['testimonial_image']->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($attributes['testimonial_image'], config('constants.SITE_PRODUCT_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $testimonialData->media()?->delete();
                        $isFileRelatedMediaCreated = $testimonialData->media()->create([
                            'user_id' => auth()->user()->id,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'is_profile_picture' => false
                        ]);
                    }
            }
        }
        return $isTestimonialUpdated;
    }

    public function deleteTestimonial($id)
    {
        return $this->delete($id);
    }
}
