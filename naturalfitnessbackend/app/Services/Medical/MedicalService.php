<?php

namespace App\Services\Medical;
use App\Contracts\Medical\MedicalContract;

class MedicalService
{
    protected $medicalRepository;
    public function __construct(MedicalContract $medicalRepository)
    {
        $this->medicalRepository= $medicalRepository;
    }
    public function listIssues($filterConditions = null, $orderBy = 'id', $sortBy = 'desc', $limit = null, $offset = null, $inRandomOrder = false, $search = null){
        return $this->medicalRepository->listIssues($filterConditions, $orderBy, $sortBy, $limit, $offset, $inRandomOrder, $search);
    }
    public function getTotalIssues($filterConditions = null, $search=null){
        return $this->medicalRepository->getTotalIssues($filterConditions, $search);
    }
    public function findIssueById($id){
        return $this->medicalRepository->findIssueById($id);
    }

    public function updateIssue(array $attributes,$id){
        return $this->medicalRepository->update($attributes,$id);
    }

    public function createOrUpdateIssue(array $attributes,$id= null){
        if(is_null($id)){
            return $this->medicalRepository->createIssue($attributes);
        }else{
            return $this->medicalRepository->updateIssue($attributes,$id);
        }
    }

    public function deleteIssue(int $id){
        return $this->medicalRepository->deleteIssue($id);
    }

    public function listQuestions($filterConditions = null, $orderBy = 'id', $sortBy = 'desc', $limit = null, $offset = null, $inRandomOrder = false, $search = null){
        return $this->medicalRepository->listQuestions($filterConditions, $orderBy, $sortBy, $limit, $offset, $inRandomOrder, $search);
    }
    public function getTotalQuestions($filterConditions = null, $search=null){
        return $this->medicalRepository->getTotalQuestions($filterConditions, $search);
    }
    public function findQuestionById($id){
        return $this->medicalRepository->findQuestionById($id);
    }

    public function updateQuestion(array $attributes,$id){
        return $this->medicalRepository->update($attributes,$id);
    }

    public function createOrUpdateQuestion(array $attributes,$id= null){
        if(is_null($id)){
            return $this->medicalRepository->createQuestion($attributes);
        }else{
            return $this->medicalRepository->updateQuestion($attributes,$id);
        }
    }

    public function deleteQuestion(int $id){
        return $this->medicalRepository->deleteQuestion($id);
    }
}
