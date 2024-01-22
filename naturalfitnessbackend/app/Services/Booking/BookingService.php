<?php

namespace App\Services\Booking;

use App\Contracts\Booking\BookingContract;

class BookingService
{
/**
     * @var BookingContract
     */
    protected $bookingRepository;

	/**
     * BookingService constructor
     */
    public function __construct(BookingContract $bookingRepository){
        $this->bookingRepository= $bookingRepository;
    }

    public function listBookings(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$offset=null,$inRandomOrder= false, $search=null){
        return $this->bookingRepository->listBookings($filterConditions,$orderBy,$sortBy,$limit,$offset,$inRandomOrder, $search);
    }

    public function getTotalData(array $filterConditions=[], $search=null){
        return $this->bookingRepository->getTotalData($filterConditions, $search);
    }


    public function getListofBookings($start, $limit, $order, $dir, $search=null){
        return $this->bookingRepository->getList($start, $limit, $order, $dir, $search);
    }
    public function findById(int $id){
        return $this->bookingRepository->find($id);
    }

    public function updateBooking(array $attributes,int $id){
        return $this->bookingRepository->update($attributes,$id);
    }

    public function createOrUpdateBooking(array $attributes,$id= null){
        if(is_null($id)){
            return $this->bookingRepository->createBooking($attributes);
        }else{
            return $this->bookingRepository->updateBooking($attributes,$id);
        }
    }

    public function delete(int $id){
        return $this->bookingRepository->delete($id);
    }

    public function addBookingLog($attributes){
        return $this->bookingRepository->addBookingLog($attributes);
    }
    public function addOrUpdateBookingDriver(array $attributes, $id=null){
        if(is_null($id)){
            return $this->bookingRepository->addBookingDriver($attributes);
        }else{
            return $this->bookingRepository->updateBookingDriver($attributes, $id);
        }
    }
    public function findBookingDriverById(int $id){
        return $this->bookingRepository->findBookingDriverById($id);
    }
    public function updateAvailability(array $attributes, $userId){
        // dd($attributes);
        return $this->bookingRepository->updateAvailability($attributes, $userId);
    }
    public function getListofDoctorsAvailabilities(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$offset=null,$inRandomOrder= false, $search=null){
        return $this->bookingRepository->getListofDoctorsAvailabilities($filterConditions,$orderBy,$sortBy,$limit,$offset,$inRandomOrder, $search);
    }

    public function getAllBookedTimesByDate($date){
        return $this->bookingRepository->getAllBookedTimesByDate($date);
    }
    public function getAllUnavailableTimesByDate($date){
        return $this->bookingRepository->getAllUnavailableTimesByDate($date);
    }
}
