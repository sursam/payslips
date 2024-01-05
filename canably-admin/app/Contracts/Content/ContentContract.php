<?php

namespace App\Contracts\Content;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface ContentContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listContents(array $filterConditions,string $orderBy = 'id', string $sortBy = 'desc', $limit= null,$inRandomOrder= false);

    /**
     * @param array $attributes
     * @return mixed
     */


    public function createContent(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateContent(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteContent(int $id);
}
