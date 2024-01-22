<?php

namespace App\Repositories\Booking;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\User\User;
use Illuminate\Support\Str;
use App\Models\Booking\Booking;
use App\Models\Booking\BookingLog;
use App\Repositories\BaseRepository;
use App\Models\Booking\BookingDriver;
use App\Models\User\DoctorsAvailability;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Booking\BookingContract;

class BookingRepository extends BaseRepository implements BookingContract
{
/**
     * BookingRepository constructor
     *
     * @param Booking $model
     */
    public function __construct(Booking $model, protected BookingLog $bookingLogModel, protected BookingDriver $bookingDriverModel, protected DoctorsAvailability $doctorsAvailability, protected User $userModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->bookingLogModel = $bookingLogModel;
        $this->bookingDriverModel = $bookingDriverModel;
        $this->doctorsAvailability = $doctorsAvailability;
        $this->userModel = $userModel;
    }

    /**
     * List of all bookings
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBookings($filterConditions, string $order = 'id', string $sort = 'desc', $limit = null, $offset = null, $inRandomOrder = false, $search = null)
    {
        $query =  $this->model;
        if (!is_null($filterConditions)) {
            if(array_key_exists('fromDate', $filterConditions) && array_key_exists('toDate', $filterConditions)) {
                $query = $query->where('scheduled_at', '>=', $filterConditions['fromDate'])
                    ->where('scheduled_at', '<=', $filterConditions['toDate']);
                unset($filterConditions['fromDate']);
                unset($filterConditions['toDate']);
            }
            $query = $query->where($filterConditions);
        }
        if ($search) {
            $createdAt = is_numeric($search) ? date('Y-m-d H:i:s', $search) : '';

            // dd($createdAt);
            // $query = $query->where('name', 'LIKE', "%{$search}%");
            $query = $query->where(function ($query) use ($search, $createdAt) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('vehicleType', function ($qr) use ($search) {
                        $qr->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('paymentMode', function ($qr) use ($search) {
                        $qr->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('bookingDriver.driver', function ($qr) use ($search) {
                        $qr->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                        ->orWhereHas('vehicle', function ($qry) use ($search) {
                            $qry->where('registration_number', 'LIKE', "%{$search}%");
                        });
                        $nameArr = explode(' ', $search);
                        $firstName = $nameArr[0];
                        $lastName = (count($nameArr) > 1) ? $nameArr[1] : '';
                        // DD($lastName);
                        if($firstName){
                            $qr->orWhere('first_name', 'LIKE', "%{$firstName}%");
                        }
                        if($lastName){
                            $qr->orWhere('last_name', 'LIKE', "%{$lastName}%");
                        }
                    });
                if($createdAt){
                    $query->orWhere('created_at', 'LIKE', "%{$createdAt}%");
                }
            });
        }
        if ($inRandomOrder) {
            $query = $query->inRandomOrder();
        } else {
            $query = $query->orderBy($order, $sort);
        }
        if ($offset) {
            $query = $query->offset($offset);
        }
        if (!is_null($limit)) {
            $query = $query->limit($limit);
        }
        return $query->get();
    }

    /**
     * Create a booking
     *
     * @param array $params
     * @return Booking|mixed
     */
    public function createBooking(array $attributes)
    {
        // dd($sattributes);
        $isBookingCreated = $this->create($attributes);
        if($isBookingCreated){
            $partner_info = [
                'name'          => $attributes['other_name'],
                'age'           => $attributes['other_age'],
                "relationship"  => $attributes['other_relationship'],
                "gender"        => $attributes['other_gender'],
            ];
            $isBookingCreated->details()->create([
                'doctor_level_id'   => $attributes['doctor_level_id'],
                'booking_for'       => $attributes['booking_for'],
                'partner_info'      => $partner_info,
                'other_info'        => $attributes['other_info'],
                'consultaion_type'  => $attributes['consultaion_type'],
                // 'survey_results'    => $attributes['survey_results']
            ]);
        }

        return $isBookingCreated;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBooking($attributes, $id)
    {
        $isBooking = $this->find($id);
        $isBookingUpdated = $this->update($attributes, $id);
        if($isBookingUpdated){
            $partner_info = [
                'name'          => $attributes['other_name'],
                'age'           => $attributes['other_age'],
                "relationship"  => $attributes['other_relationship'],
                "gender"        => $attributes['other_gender'],
            ];
            $isBooking->details()->update([
                'doctor_level_id'   => $attributes['doctor_level_id'],
                'booking_for'       => $attributes['booking_for'],
                'partner_info'      => $partner_info,
                'other_info'        => $attributes['other_info'],
                'consultaion_type'  => $attributes['consultaion_type'],
                // 'survey_results'    => $attributes['survey_results']
            ]);
        }
        return $isBookingUpdated;
    }


    /**
     * Get count of total bookings
     *
     * @param null $search
     * @return mixed
     */
    public function getTotalData($filterConditions = [], $search = null)
    {
        $query =  $this->model;
        if (!is_null($filterConditions)) {
            if(array_key_exists('fromDate', $filterConditions) && array_key_exists('toDate', $filterConditions)) {
                $query = $query->where('scheduled_at', '>=', $filterConditions['fromDate'])
                    ->where('scheduled_at', '<=', $filterConditions['toDate']);
                unset($filterConditions['fromDate']);
                unset($filterConditions['toDate']);
            }
            $query = $query->where($filterConditions);
        }
        if ($search) {
            $createdAt = is_numeric($search) ? date('Y-m-d H:i:s', $search) : '';

            // dd($createdAt);
            // $query = $query->where('name', 'LIKE', "%{$search}%");
            $query = $query->where(function ($query) use ($search, $createdAt) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('vehicleType', function ($qr) use ($search) {
                        $qr->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('paymentMode', function ($qr) use ($search) {
                        $qr->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('bookingDriver.driver', function ($qr) use ($search) {
                        $qr->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                        ->orWhereHas('vehicle', function ($qry) use ($search) {
                            $qry->where('registration_number', 'LIKE', "%{$search}%");
                        });
                        $nameArr = explode(' ', $search);
                        $firstName = $nameArr[0];
                        $lastName = (count($nameArr) > 1) ? $nameArr[1] : '';
                        // DD($lastName);
                        if($firstName){
                            $qr->orWhere('first_name', 'LIKE', "%{$firstName}%");
                        }
                        if($lastName){
                            $qr->orWhere('last_name', 'LIKE', "%{$lastName}%");
                        }
                    });
                if($createdAt){
                    $query->orWhere('created_at', 'LIKE', "%{$createdAt}%");
                }
            });
        }
        return $query->count();
    }

    /**
     * Get list of bookings for datatable
     *
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getList($start, $limit, $order, $dir, $search = null)
    {
        $query = $this->model;

        if ($search) {
            $query = $query = $query->where('name', 'LIKE', "%{$search}%");
        }

        return $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    }
    public function addBookingLog(array $attributes)
    {
        $isLogCreated = $this->bookingLogModel->create($attributes);
        return $isLogCreated;
    }
    public function addBookingDriver(array $attributes)
    {
        $isBookingDriverCreated = $this->bookingDriverModel->create($attributes);
        return $isBookingDriverCreated;
    }
    public function updateBookingDriver(array $attributes, $id)
    {
        $isBookingDriverUpdated = $this->bookingDriverModel->find($id)->update($attributes);
        return $isBookingDriverUpdated;
    }
    public function findBookingDriverById($id)
    {
        $isBookingDriver = $this->bookingDriverModel->where(['booking_id' => $id])->first();
        return $isBookingDriver;
    }
    public function updateAvailability(array $attributes, $userId)
    {
        // dd($attributes);
        $data = [];
        if(isset($attributes['available_from']) && isset($attributes['available_to'])){
            foreach($attributes['available_from'] as $day => $attribute){
                if($attribute[0]){
                    foreach($attribute as $k => $from_time){
                        $data[] = ['uuid' => Str::uuid(), 'doctor_id' => $userId, 'available_day' => $day, 'available_from' => Carbon::parse($from_time)->format('H:i:s'), 'available_to' => Carbon::parse($attributes['available_to'][$day][$k])->format('H:i:s'), 'created_at' => now(), 'updated_at' => now()];
                    }
                }else{
                    $data[] = ['uuid' => Str::uuid(), 'doctor_id' => $userId, 'available_day' => $day, 'available_from' => null, 'available_to' => null, 'created_at' => now(), 'updated_at' => now()];
                }
            }
        }
        // dd($data);
        $isAvailabilityAdded = $this->doctorsAvailability->insert($data);
        // dd($isAvailabilityAdded);
        return $isAvailabilityAdded;
    }
    public function getListofDoctorsAvailabilities($filterConditions, string $order = 'id', string $sort = 'desc', $limit = null, $offset = null, $inRandomOrder = false, $search = null)
    {
        $query =  $this->doctorsAvailability;
        if (!is_null($filterConditions)) {
            $query = $query->where($filterConditions);
        }
        if ($search) {
            $createdAt = is_numeric($search) ? date('Y-m-d H:i:s', $search) : '';

            // dd($createdAt);
            // $query = $query->where('name', 'LIKE', "%{$search}%");
            $query = $query->where(function ($query) use ($search, $createdAt) {
                $query->where('name', 'LIKE', "%{$search}%");
                if($createdAt){
                    $query->orWhere('created_at', 'LIKE', "%{$createdAt}%");
                }
            });
        }
        if ($inRandomOrder) {
            $query = $query->inRandomOrder();
        } else {
            $query = $query->orderBy($order, $sort);
        }
        if ($offset) {
            $query = $query->offset($offset);
        }
        if (!is_null($limit)) {
            $query = $query->limit($limit);
        }
        return $query->get()->groupBy('available_day');
    }
    public function getAllBookedTimesByDate($date)
    {
        $query = $this->model->whereDate('booking_datetime', $date);
        return $query->pluck('booking_datetime')->toArray();
    }
    public function getAllUnavailableTimesByDate($date)
    {
        $role = 'doctor';
        $totalDoctors = $this->userModel->whereHas('roles', function (Builder $query) use ($role) {
            $query->where('slug', $role);
        })->count();

        $bookedTimes = $this->model
                    ->whereDate('booking_datetime', $date)
                    ->where('status', 1)
                    ->get()
                    ->groupBy('booking_datetime')
                    ->toArray();

        $disableTimes = array();
        $startPeriod    = Carbon::parse($date.' 8:00:00');
        $endPeriod      = Carbon::parse($date.' 18:00:00');
        $period         = CarbonPeriod::create($startPeriod, '15 minutes', $endPeriod);
        foreach ($period as $time){
            $timeSlot = Carbon::parse($time)->format('Y-m-d H:i:s');
            $availabilitiesCount =  $this->doctorsAvailability
                ->where('available_day', Carbon::parse($date)->format('l'))
                ->where('available_from', '<>', null)
                ->where('available_from', '<=', $timeSlot)
                ->where('available_to', '>=', $timeSlot)
                ->where('is_active', 1)
                ->count();
            if((array_key_exists($timeSlot, $bookedTimes) && count($bookedTimes[$timeSlot]) == $totalDoctors) || !$availabilitiesCount){
                $disableTimes[] = $timeSlot;
            }
        }
        // dd($disableTimes);

        return $disableTimes;
    }
}
