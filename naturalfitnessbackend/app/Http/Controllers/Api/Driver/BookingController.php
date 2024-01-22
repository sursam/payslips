<?php

namespace App\Http\Controllers\Api\Driver;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Services\Booking\BookingService;
use App\Http\Resources\Api\BookingResource;

class BookingController extends BaseController
{
    public function __construct(
        protected BookingService $bookingService,
        protected UserService $userService)
    {
        $this->bookingService = $bookingService;
        $this->userService = $userService;
    }
    public function getBookings(Request $request)
    {
        $status = $request->status;
        try {
            $filterConditions = ['status' => $status];
            $bookings = $this->bookingService->listBookings($filterConditions);
            return $this->responseJson(true, 200, "Bookings successfully found.", BookingResource::collection($bookings));
        } catch (\Exception$e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function setBookingStatus(Request $request)
    {
        if ($request->post()) {
            $bookingId = uuidtoid($request->booking_uuid,'bookings');
            try {
                DB::beginTransaction();
                $bookingData = $this->bookingService->findById($bookingId);
                $status = $request->status;
                switch($status){
                    case 1: $statusText = 'accepted'; break;
                    case 2: $statusText = 'cancelled'; break;
                    case 3: $statusText = 'rejected'; break;
                    case 4: $statusText = 'completed'; break;
                }
                if($bookingData && (strtotime($bookingData->scheduled_at) < time())) {
                    $verificationCode = ($status == 1) ? generateOtp() : null;
                    $request->merge([
                        'status' => $status,
                        'verification_code' => $verificationCode,
                        'updated_at' => now(),
                    ]);
                    $isBookingUpdated = $this->bookingService->createOrUpdateBooking($request->except(['_token']), $bookingId);
                    if($isBookingUpdated){
                        $data = [
                            'booking_id' => $bookingId,
                            'user_id' => auth()->user()->id,
                            "comment" => $request->comment ? $request->comment : "Booking $statusText",
                            "previous_status" => $bookingData->status,
                            "status" => $status,
                        ];
                        $this->bookingService->addBookingLog($data);
                        $bookingDriverData = $this->bookingService->findBookingDriverById($bookingId);
                        $bookingDriverId = $bookingDriverData ? $bookingDriverData->id : null;
                        $this->bookingService->addOrUpdateBookingDriver($data, $bookingDriverId);
                        // $text = getSiteSetting('driver_login_otp_template') ? getSiteSetting('driver_login_otp_template') : "Your%20Da%27Ride%20Driver%20App%20Verification%20Otp%20is%20{CODE}.%20Thank%20you.";
                        // $text = str_replace('{CODE}',$verificationCode,$text);
                        // $smsResponse = sendSms(auth()->user()->mobile_number, $text);
                        // if($smsResponse->ok()){
                        // }
                        DB::commit();

                        return $this->responseJson(true, 200, "Booking successfully $statusText.", new BookingResource($bookingData->fresh()));
                    }
                }
                return $this->responseJson(false, 200, "Booking does not exist", []);
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
                return $this->responseJson(false, 500, $e->getMessage(), []);
            }
        }
    }
}
