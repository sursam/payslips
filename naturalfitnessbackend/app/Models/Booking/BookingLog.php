<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingLog extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'booking_id',
        'user_id',
        'comment',
        'previous_status',
        'status'
    ];
}
