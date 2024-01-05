<?php

namespace App\Repositories\Faq;

use App\Contracts\Faq\FaqContract;
use App\Models\Faq;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class BlogRepository
 *
 * @package \App\Repositories
 */
class FaqRepository extends BaseRepository implements FaqContract
{
    use UploadAble;

    protected $model;
    /**
     * BlogRepository constructor.
     * @param Faq $model
     */
    public function __construct(Faq $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listFaqs($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $faqs = $this->model;
        if (!is_null($filterConditions)) {
            $faqs = $faqs->where($filterConditions);
        }
        $faqs = $faqs->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $faqs->paginate($limit);
        }
        return $faqs->get();
    }
    public function createFaq($attributes)
    {
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        return $this->create($attributes);
    }

    public function updateFaq($attributes, $id)
    {
        $faqData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        return $faqData->update($attributes);
    }
}
