<?php

namespace App\Repositories\Product;
use App\Models\Company\Service;
use App\Contracts\Product\ProductContract;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductContract
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
