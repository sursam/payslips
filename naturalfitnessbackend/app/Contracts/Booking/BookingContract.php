<?php

namespace App\Contracts\Booking;

/**
 * Interface BookingContract
 * @package App\Contracts
 */
interface BookingContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBookings(array $filterConditions,string $order = 'id', string $sort = 'desc', $limit= null,$inRandomOrder= false);
    /**
     * @param array $params
     * @return mixed
     */
    public function createBooking(array $params);
    /**
     * @param array $params
     * @return mixed
     */
    public function updateBooking(array $params,string $id);
}
