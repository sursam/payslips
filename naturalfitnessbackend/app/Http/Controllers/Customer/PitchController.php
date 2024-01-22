<?php

namespace App\Http\Controllers\Customer;

use App\Models\module\Pitch;
use Illuminate\Http\Request;
use App\Models\Company\Company;
use App\Models\Company\Director;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Company\InitialEnquiry;
use App\Models\Company\ProjectActivity;
use App\Http\Controllers\BaseController;

class PitchController extends BaseController
{
    public function pitchCreate(Request $request)
    {
        if ($request->post()) {
            $fYearInsert = array(
                'company_id' => $request->company_id,
                'is_active' => 1
            );
            $fYearSave = Pitch::create($fYearInsert);
            if (!empty($fYearSave)) {
                return redirect()->route('customer.initial.enquiry', ['uuid' => $fYearSave->uuid]);
            }
        }
        $companies = Company::where('user_id', auth()->user()->id)->get();
        return view('customer.pitch.pitch_create', compact('companies'));
    }
    public function initialEnquiry(Request $request)
    {
        $pitch = Pitch::where('uuid', $request->uuid)->first();
        $initialEnquiry = array();
        $directors = array();
        $otherDirectors = array();
        if (!empty($pitch->step_one_id)) {
            $initialEnquiry = InitialEnquiry::where('id', $pitch->step_one_id)->first();
            $directors = Director::where(['initial_enquiry_id' => $pitch->step_one_id,'secretary_position' => '0'])->get();
            $otherDirectors = Director::where(['initial_enquiry_id' => $pitch->step_one_id,'secretary_position' => '1'])->get();
        }
        return view('customer.pitch.initial_enquiry', compact('pitch','initialEnquiry','directors','otherDirectors'));
    }
    public function projectActivities(Request $request)
    {
        $pitch = Pitch::where('uuid', $request->uuid)->first();
        $projectActivities = array();
        if (!empty($pitch->step_two_id)) {
            $projectActivities = ProjectActivity::with('supplier')->whereIn('id', json_decode($pitch->step_two_id))->get();
        }
        // dd($projectActivities->toArray());
        return view('customer.pitch.project_activities', compact('pitch','projectActivities'));
    }
    public function applicationForm(Request $request)
    {
        $pitch = Pitch::where('uuid', $request->uuid)->first();
        return view('customer.pitch.application_form', compact('pitch'));
    }
    public function financialQuestion(Request $request)
    {
        $pitch = Pitch::where('uuid', $request->uuid)->first();
        return view('customer.pitch.financial_question', compact('pitch'));
    }
}
