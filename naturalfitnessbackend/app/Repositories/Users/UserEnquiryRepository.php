<?php

namespace App\Repositories\Users;
use App\Models\User\UserEnquiry;
use App\Repositories\BaseRepository;
use App\Contracts\Users\UserEnquiryContract;

class UserEnquiryRepository extends BaseRepository implements UserEnquiryContract
{
    public function __construct(UserEnquiry $model)
    {
        parent::__construct($model);
    }
}
