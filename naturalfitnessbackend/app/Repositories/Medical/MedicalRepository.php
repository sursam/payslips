<?php

namespace App\Repositories\Medical;
use App\Models\Medical\Issue;
use App\Contracts\Medical\MedicalContract;
use App\Models\Site\Question;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MedicalRepository extends BaseRepository implements MedicalContract
{
    protected $issueModel;
    protected $questionModel;
    public function __construct(Issue $issueModel, Question $questionModel)
    {
        $this->issueModel = $issueModel;
        $this->questionModel = $questionModel;
    }
    /**
     * Get list of issues for datatable
     *
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function listIssues($filterConditions = null, $orderBy = 'id', $sortBy = 'desc', $limit = null, $offset = null, $inRandomOrder = false, $search = null)
    {
        $query = $this->issueModel;
        if ($filterConditions) {
            $query = $query->where($filterConditions);
        }
        if($search) {
            $query = $query->where('name','LIKE',"%{$search}%");
        }
        if ($inRandomOrder) {
            $query = $query->inRandomOrder();
        } else {
            $query = $query->orderBy($orderBy, $sortBy);
        }
        if ($offset ) {
            $query = $query->offset($offset);
        }
        if ($limit) {
            $query = $query->limit($limit);
        }

        return $query->get();
    }
    /**
     * Find a issue with id
     *
     *
     */
    public function findIssueById(int $id)
    {
        try
        {
            return $this->issueModel->find($id);

        }
        catch (ModelNotFoundException $exception)
        {
            throw new ModelNotFoundException($exception);
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function createIssue($attributes)
    {
        $isIssueCreated = $this->issueModel->create($attributes);
        return $isIssueCreated;
    }
    public function updateIssue($attributes,$id)
    {
        $isIssue = $this->issueModel->find($id);
        $isIssueUpdated = $isIssue->update($attributes);
        return $isIssueUpdated;
    }

    /**
     * Delete a issue
     *
     * @param $id
     * @return bool|mixed
     */
    public function deleteIssue($id)
    {
        $issue = $this->issueModel->find($id);
        $issue?->delete();

        return $issue ?? false;
    }

    /**
     * Get count of total issues
     *
     * @param null $search
     * @return mixed
     */
    public function getTotalIssues($filterConditions = null, $search=null)
    {
        $query = $this->issueModel;
        if ($filterConditions) {
            $query = $query->where($filterConditions);
        }
        if($search) {
            $query = $query->where('name','LIKE',"%{$search}%");
        }

        return $query->count();
    }

    /**
     * Get list of questions for datatable
     *
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function listQuestions($filterConditions = null, $orderBy = 'id', $sortBy = 'desc', $limit = null, $offset = null, $inRandomOrder = false, $search = null)
    {
        $query = $this->questionModel;
        if ($filterConditions) {
            $query = $query->where($filterConditions);
        }
        if($search) {
            $query = $query->where('name','LIKE',"%{$search}%");
        }
        if ($inRandomOrder) {
            $query = $query->inRandomOrder();
        } else {
            $query = $query->orderBy($orderBy, $sortBy);
        }
        if ($offset ) {
            $query = $query->offset($offset);
        }
        if ($limit) {
            $query = $query->limit($limit);
        }

        return $query->get();
    }
    /**
     * Find a question with id
     *
     *
     */
    public function findQuestionById(int $id)
    {
        try
        {
            return $this->questionModel->find($id);

        }
        catch (ModelNotFoundException $exception)
        {
            throw new ModelNotFoundException($exception);
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function createQuestion($attributes)
    {
        // dd($attributes);
        $isQuestionCreated = $this->questionModel->create($attributes);
        if($isQuestionCreated){
            $isQuestionCreated->issues()->attach($attributes['issues']);
            if($attributes['option_value']){
                foreach($attributes['option_value'] as $option_value){
                    $isQuestionCreated->options()->create([
                        'option_value' => $option_value
                    ]);
                }
            }
        }
        return $isQuestionCreated;
    }
    public function updateQuestion($attributes,$id)
    {
        $isQuestion = $this->questionModel->find($id);
        $isQuestionUpdated = $isQuestion->update($attributes);
        if($isQuestionUpdated){
            $isQuestion->issues()->sync($attributes['issues']);
            if($attributes['option_value']){
                $isQuestion->options()->forceDelete();
                foreach($attributes['option_value'] as $option_value){
                    $isQuestion->options()->create([
                        'option_value' => $option_value
                    ]);
                }
            }
        }
        return $isQuestionUpdated;
    }

    /**
     * Delete a question
     *
     * @param $id
     * @return bool|mixed
     */
    public function deleteQuestion($id)
    {
        $question = $this->questionModel->find($id);
        $question?->delete();

        return $question ?? false;
    }

    /**
     * Get count of total questions
     *
     * @param null $search
     * @return mixed
     */
    public function getTotalQuestions($filterConditions = null, $search=null)
    {
        $query = $this->questionModel;
        if ($filterConditions) {
            $query = $query->where($filterConditions);
        }
        if($search) {
            $query = $query->where('name','LIKE',"%{$search}%");
        }

        return $query->count();
    }
}
