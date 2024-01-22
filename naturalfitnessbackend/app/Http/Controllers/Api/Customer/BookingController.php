<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Services\Booking\BookingService;
use Illuminate\Support\Facades\Validator;
use App\Services\Fare\FareService;
use App\Http\Resources\Api\BookingResource;
use Illuminate\Support\Facades\Http;

class BookingController extends BaseController
{
    public function __construct(
        protected BookingService $bookingService,
        protected UserService $userService,
        protected FareService $fareService)
    {
        $this->bookingService = $bookingService;
        $this->userService = $userService;
        $this->fareService = $fareService;
    }
    public function bookRide(Request $request)
    {
        if ($request->post()) {
            $validator = Validator::make($request->all(), [
                'category_uuid' => 'required|string|exists:categories,uuid',
                'payment_mode_uuid' => 'required|string|exists:payment_modes,uuid',
                'scheduled_at' => 'required|date',
                'pickup.address' => 'required|string',
                'pickup.pincode' => 'required|string',
                'pickup.latitude' => 'required|numeric',
                'pickup.longitude' => 'required|numeric',
                'pickup.address_type' => 'nullable|string',
                'drop.*.address' => 'required|string',
                'drop.*.pincode' => 'required|string',
                'drop.*.latitude' => 'required|numeric',
                'drop.*.longitude' => 'required|numeric',
                'drop.*.address_type' => 'nullable|string'
            ]);
            if ($validator->fails()) return $this->responseJson(false, 200, $validator->errors(), (object)[]);
            DB::beginTransaction();
            try {
                $totalPrice = 0;
                $categoryId = uuidtoid($request->category_uuid,'categories');
                $responseData = $this->calculateEstimatedPrice($categoryId, $request->scheduled_at, $request['pickup']['latitude'], $request['pickup']['longitude'], $request['drop'][0]['latitude'], $request['drop'][0]['longitude']);
                if(isset($responseData['price'])){
                    $totalPrice += $responseData['price'];
                }
                if(count($request['drop']) > 1){
                    foreach($request['drop'] as $k => $drop){
                        if(array_key_exists(($k + 1), $request['drop'])){
                            $responseData = $this->calculateEstimatedPrice($categoryId, $request->scheduled_at, $request['drop'][$k]['latitude'], $request['drop'][$k]['longitude'], $request['drop'][($k+1)]['latitude'], $request['drop'][($k+1)]['longitude']);
                            if(isset($responseData['price'])){
                                $totalPrice += $responseData['price'];
                            }
                        }
                    }
                }
                $request->merge([
                    'name' => auth()->user()->full_name,
                    'mobile_number' => auth()->user()->mobile_number,
                    'user_id' => auth()->user()->id,
                    'category_id' => uuidtoid($request->category_uuid,'categories'),
                    'payment_mode_id' => uuidtoid($request->payment_mode_uuid,'payment_modes'),
                    'price' => $totalPrice
                ]);
                $isBookingCreated = $this->bookingService->createOrUpdateBooking($request->except(['_token']));
                if($isBookingCreated){
                    $this->bookingService->addBookingLog([
                        'booking_id' => $isBookingCreated->id,
                        'user_id' => auth()->user()->id,
                        "comment" => "Booking initiated",
                        "status" => 0,
                    ]);
                    DB::commit();
                    return $this->responseJson(true, 200, "Booking successfully created.", new BookingResource($isBookingCreated));
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
                return $this->responseJson(false, 500, $e->getMessage(), []);
            }
        }
    }
    public function calculateFare(Request $request)
    {
        if ($request->post()) {
            $categoryId = uuidtoid($request->category_uuid,'categories');
            try {
                $responseData = $this->calculateEstimatedPrice($categoryId, $request->scheduled_at, $request['pickup']['latitude'], $request['pickup']['longitude'], $request['drop']['latitude'], $request['drop']['longitude']);
                return $this->responseJson(true, 200, "Data found successfully.", [$responseData]);
            } catch (\Exception$e) {
                logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
                return $this->responseJson(false, 500, $e->getMessage(), []);
            }
        }
    }
    protected function calculateEstimatedPrice($categoryId, $scheduledAt, $pickupLat, $pickupLong, $dropLat, $dropLong){
        $filterConditions = ['category_id' => $categoryId];
        $fareData = $this->fareService->getFareBetweenTimes(date('H:i', strtotime($scheduledAt)), $filterConditions);
        try {
            $distanceResponse = Http::withUrlParameters([
                'endpoint' => config('constants.GOOGLE_MAP_DISTANCE_URL'),
                'origin' => $pickupLat . ',' . $pickupLong,
                'destination' => $dropLat . ',' . $dropLong,
                'key' => config('constants.GOOGLE_MAP_API_KEY'),
            ])->get('{+endpoint}?origins={origin}&destinations={destination}&mode=driving&key={key}');
            if ($distanceResponse->ok()) {
                $data = $distanceResponse->json();
                // dd($fareData);
                $distance = $data['rows'][0]['elements'][0]['distance']['text'] ? $data['rows'][0]['elements'][0]['distance']['text'] : 0;
                $price = (float) $distance * $fareData['amount'];
                return [
                    'origin' => $data['origin_addresses'][0] ?? '',
                    'destination' => $data['destination_addresses'][0] ?? '',
                    'distance' => $data['rows'][0]['elements'][0]['distance']['text'] ?? '',
                    'eta' => $data['rows'][0]['elements'][0]['duration']['text'] ?? '',
                    'price' => $price,
                ];
            }
        } catch (\Exception$e) {
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return [];
        }
    }

}
