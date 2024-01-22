<?php

namespace App\Services\User;
use App\Contracts\Users\UserEnquiryContract;

class UserEnquiryService
{
    protected $userEnquiryRepository;
    public function __construct(UserEnquiryContract $userEnquiryRepository)
    {
        $this->userEnquiryRepository = $userEnquiryRepository;
    }
    public function find(int $id)
    {
        return $this->userEnquiryRepository->find($id);
    }
    public function create(array $attributes)
    {
        return $this->userEnquiryRepository->create($attributes);
    }
    public function update(array $attributes,$id){
        return $this->userEnquiryRepository->update($attributes,$id);
    }
    public function delete(int $id)
    {
        return $this->userEnquiryRepository->delete($id);
    }

    public function findUserEnquiryByUserId($userId){
        return $this->userEnquiryRepository->findOneBy([
            'user_id' => $userId
        ]);
    }
}
