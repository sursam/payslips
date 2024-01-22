<?php

namespace App\Http\Controllers\Admin\Medical;

use App\Services\Medical\MedicalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class MedicalController extends BaseController
{
    public function __construct(protected MedicalService $medicalService){
        $this->medicalService = $medicalService;
    }
    public function listIssues(Request $request){
        $this->setPageTitle('List Issues');
        return view('admin.issue.list');
    }
    public function addIssue(Request $request){
        $this->setPageTitle('Add Issue');
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
                'type'=>'required'
            ]);
            DB::beginTransaction();
            try {
                $isIssueCreated = $this->medicalService->createOrUpdateIssue($request->except('_token'));
                if ($isIssueCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.medical.issue.list', 'Issue created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.issue.add');
    }
    public function editIssue(Request $request,$uuid){
        $this->setPageTitle('Edit Issue');
        $issueId = uuidtoid($uuid,'issues');
        $issueData = $this->medicalService->findIssueById($issueId);
        // dd($issueData);
        if($request->post()){
            $request->validate([
                'name' => 'required',
                'type'=>'required'
            ]);
            DB::beginTransaction();
             try{
                $isIssueUpdated= $this->medicalService->createOrUpdateIssue($request->except('_token'), $issueId);
                if($isIssueUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.medical.issue.list','Issue updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.issue.edit',compact('issueData'));
    }
    public function listQuestions(Request $request){
        $this->setPageTitle('List Questions');
        return view('admin.question.list');
    }
    public function addQuestion(Request $request){
        $this->setPageTitle('Add Question');
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
                'type'=>'required',
                'issues'=>'required',
                'option_value'=>'required_if:type,radio,checkbox'
            ],
            [
                'name.required' => 'Please enter a question',
                'type.required' => 'Question type is required',
                'issues.required' => 'Please select related issues',
                'option_value.required_if' => 'Please enter option value'
            ]);
            DB::beginTransaction();
            try {
                $isQuestionCreated = $this->medicalService->createOrUpdateQuestion($request->except('_token'));
                if ($isQuestionCreated) {
                    DB::commit();
                    return $this->responseJson(true, 200, 'Question created successfully', ['redirect_url' => route('admin.medical.question.list')]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong', []);
            }
        }
        $issues = $this->medicalService->listIssues();
        return view('admin.question.add', compact('issues'));
    }
    public function editQuestion(Request $request,$uuid){
        $this->setPageTitle('Edit Question');
        $questionId = uuidtoid($uuid,'questions');
        $questionData = $this->medicalService->findQuestionById($questionId);
        // dd($questionData);
        if($request->post()){
            $request->validate([
                'name' => 'required',
                'type'=>'required',
                'issues'=>'required',
                'option_value'=>'required_if:type,radio,checkbox'
            ],
            [
                'name.required' => 'Please enter a question',
                'type.required' => 'Question type is required',
                'issues.required' => 'Please select related issues',
                'option_value.required_if' => 'Please enter option value'
            ]);
            DB::beginTransaction();
             try{
                $isQuestionUpdated= $this->medicalService->createOrUpdateQuestion($request->except('_token'), $questionId);
                if($isQuestionUpdated){
                    DB::commit();
                    return $this->responseJson(true, 200, 'Question updated successfully', ['redirect_url' => route('admin.medical.question.list')]);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        $issues = $this->medicalService->listIssues();
        return view('admin.question.edit',compact('questionData', 'issues'));
    }

}
