<?php

namespace App\Contracts\Support;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface SupportAnswerContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listSupportAnswers(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createSupportAnswer(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateSupportAnswer(array $attributes, int $id);

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */

     public function findSupportAnswerById(int $id);
}
