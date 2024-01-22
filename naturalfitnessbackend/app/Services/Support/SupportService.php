<?php

namespace App\Services\Support;

use App\Contracts\Support\SupportContract;

class SupportService
{
    /**
     * @var SupportContract
     */
    protected $supportRepository;

    /**
     * FaqService constructor
     */
    public function __construct(SupportContract $supportRepository)
    {
        $this->supportRepository = $supportRepository;
    }
    public function listSupports(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->supportRepository->listSupports($filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    public function findSupportById($id)
    {
        return $this->supportRepository->find($id);
    }

    public function createOrUpdateSupport(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->supportRepository->createSupport($attributes);
        } else {
            return $this->supportRepository->updateSupport($attributes, $id);
        }
    }
    public function updateSupportStatus($attributes, $id)
    {
        $attributes['is_active'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->supportRepository->update($attributes, $id);
    }

    public function deleteSupport(int $id)
    {
        return $this->supportRepository->delete($id);
    }
}
