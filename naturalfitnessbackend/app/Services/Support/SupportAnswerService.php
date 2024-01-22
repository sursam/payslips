<?php

namespace App\Services\Support;

use App\Contracts\Support\SupportAnswerContract;

class SupportAnswerService
{
        /**
     * @var SupportAnswerContract
     */
    protected $supportAnswerRepository;

    /**
     * FaqService constructor
     */
    public function __construct(SupportAnswerContract $supportAnswerRepository)
    {
        $this->supportAnswerRepository = $supportAnswerRepository;
    }
    public function listSupportAnswers(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->supportAnswerRepository->listSupportAnswers($filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    public function findSupportAnswerById($id)
    {
        return $this->supportAnswerRepository->find($id);
    }

    public function createOrUpdateSupportAnswer(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->supportAnswerRepository->createSupportAnswer($attributes);
        } else {
            return $this->supportAnswerRepository->updateSupportAnswer($attributes, $id);
        }
    }
    public function updateSupportAnswerStatus($attributes, $id)
    {
        $attributes['is_active'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->supportAnswerRepository->update($attributes, $id);
    }

    public function deleteSupportAnswer(int $id)
    {
        return $this->supportAnswerRepository->delete($id);
    }
}
