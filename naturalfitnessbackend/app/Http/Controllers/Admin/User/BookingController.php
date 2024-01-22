<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Services\Booking\BookingService;
use App\Services\Medical\MedicalService;
use App\Services\Vehicle\VehicleService;
use App\Services\Category\CategoryService;

class BookingController extends BaseController
{
    public function __construct(
        protected UserService $userService,
        protected CategoryService $categoryService,
        protected VehicleService $vehicleService,
        protected BookingService $bookingService,
        protected MedicalService $medicalService,
    )
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->vehicleService = $vehicleService;
        $this->bookingService = $bookingService;
        $this->medicalService = $medicalService;
    }
    public function index(Request $request, $status = '')
    {
        $this->setPageTitle('Bookings');
        return view('admin.bookings.index', compact('status'));
    }
    public function viewBookingDetails(Request $request, $uuid)
    {
        $this->setPageTitle('View Booking Details');
        $id = uuidtoid($uuid, 'bookings');
        $bookingData = $this->bookingService->findById($id);
        // dd($bookingData->addresses);
        return view('admin.bookings.view', compact('bookingData'));
    }
    public function addBooking(Request $request){
        $this->setPageTitle('Create Booking');
        if ($request->post()) {
            $request->validate(
                [
                    'patient_id' => 'required',
                    // 'doctor_id' => 'required',
                    "issue_id" => 'required',
                    "booking_for" => 'required',
                    "other_name" => 'required_if:booking_for,other',
                    "other_age" => 'required_if:booking_for,other',
                    "other_relationship" => 'required_if:booking_for,other',
                    "other_gender" => 'required_if:booking_for,other',
                    "consultaion_type" => 'required',
                    "doctor_level_id" => 'required',
                    "booking_date" => 'required',
                    "booking_datetime" => 'required',
                ],
                [
                    'patient_id' => 'Please select a patient',
                    // 'doctor_id' => 'required',
                    "issue_id" => 'Please select an issue',
                    "booking_for" => 'Please select whom do you booking for',
                    "other_name" => 'Name is required',
                    "other_age" => 'Age is required',
                    "other_relationship" => 'Please enter relationship with the patient',
                    "other_gender" => 'Gender is required',
                    "consultaion_type" => 'Please select type of consultation',
                    "doctor_level_id" => 'Please select whom you want',
                    "booking_date" => 'Booking date is required',
                    "booking_datetime" => 'Booking time is required',
                ]
            );
            DB::beginTransaction();
            try {
                $request->merge(['status' => 1]);
                $isBookingCreated = $this->bookingService->createOrUpdateBooking($request->except('_token'));
                if ($isBookingCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.booking.list', 'Booking created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        $filterConditionsCategory = ['type' => 'doctor_level'];
        $doctorLevels = $this->categoryService->listCategories($filterConditionsCategory);
        $patients = $this->userService->findUserByRole([], 'patient');
        $doctors = $this->userService->findUserByRole([], 'doctor');
        $issues = $this->medicalService->listIssues([]);
        return view('admin.bookings.add', compact('doctorLevels', 'patients', 'doctors', 'issues'));
    }
    public function editBooking(Request $request,$uuid){
        $this->setPageTitle('Edit Booking');
        $bookingId = uuidtoid($uuid,'bookings');
        //dd($bookingId);
        if($request->post()){
            $request->validate(
                [
                    'patient_id' => 'required',
                    // 'doctor_id' => 'required',
                    "issue_id" => 'required',
                    "booking_for" => 'required',
                    "other_name" => 'required_if:booking_for,other',
                    "other_age" => 'required_if:booking_for,other',
                    "other_relationship" => 'required_if:booking_for,other',
                    "other_gender" => 'required_if:booking_for,other',
                    "consultaion_type" => 'required',
                    "doctor_level_id" => 'required',
                    "booking_date" => 'required',
                    "booking_datetime" => 'required',
                ],
                [
                    'patient_id' => 'Please select a patient',
                    // 'doctor_id' => 'required',
                    "issue_id" => 'Please select an issue',
                    "booking_for" => 'Please select whom do you booking for',
                    "other_name" => 'Name is required',
                    "other_age" => 'Age is required',
                    "other_relationship" => 'Please enter relationship with the patient',
                    "other_gender" => 'Gender is required',
                    "consultaion_type" => 'Please select type of consultation',
                    "doctor_level_id" => 'Please select whom you want',
                    "booking_date" => 'Booking date is required',
                    "booking_datetime" => 'Booking time is required',
                ]
            );
            DB::beginTransaction();
             try{
                $isBookingUpdated= $this->bookingService->createOrUpdateBooking($request->except('_token'), $bookingId);
                if($isBookingUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.booking.list','Booking updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        $filterConditionsCategory = ['type' => 'doctor_level'];
        $doctorLevels = $this->categoryService->listCategories($filterConditionsCategory);
        $patients = $this->userService->findUserByRole([], 'patient');
        $doctors = $this->userService->findUserByRole([], 'doctor');
        $issues = $this->medicalService->listIssues([]);
        $bookingData = $this->bookingService->findById($bookingId);
        // dd($bookingData->details->partner_info);
        return view('admin.bookings.edit', compact('doctorLevels', 'patients', 'doctors', 'issues', 'bookingData'));
    }

    public function listDoctorsAvailability(Request $request){
        $this->setPageTitle("List Doctor's Availabilities");
        return view('admin.bookings.doctors-availability.list');
    }
    public function alterDoctorsAvailability(Request $request, $uuid){
        $this->setPageTitle("Update Doctor's Availabilities");
        $userId = uuidtoid($uuid, 'users');
        $userData = $this->userService->findUserById($userId);
        $data = [
            ['uuid' => Str::uuid(), 'doctor_id' => $userId, 'available_day' => 'Sunday', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'doctor_id' => $userId, 'available_day' => 'Monday', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'doctor_id' => $userId, 'available_day' => 'Tuesday', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'doctor_id' => $userId, 'available_day' => 'Wednesday', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'doctor_id' => $userId, 'available_day' => 'Thursday', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'doctor_id' => $userId, 'available_day' => 'Friday', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'doctor_id' => $userId, 'available_day' => 'Saturday', 'created_at' => now(), 'updated_at' => now()]
        ];
        if($userData->availabilities->isEmpty()){
            $userData->availabilities()->insert($data);
        }
        $availabilityData = $this->bookingService->getListofDoctorsAvailabilities(['doctor_id' => $userId]);
        // dd($availabilityData);
        if ($request->post()) {
            // $request->validate([
            //     'available_day' => 'required',
            //     'available_from' => 'required',
            //     "available_to" => 'required',
            // ]);
            DB::beginTransaction();
            try {
                $userData->availabilities()->delete();
                $isAvalabilityAltered = $this->bookingService->updateAvailability($request->except('_token'), $userId);
                if ($isAvalabilityAltered) {
                    DB::commit();
                    return $this->responseJson(true, 200, 'Availability added successfully');
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack(false, 500, 'Something went wrong');
            }
        }
        return view('admin.bookings.doctors-availability.alter', compact('availabilityData', 'userData'));
    }
}
