<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingAddress extends Model
{
    use HasFactory,SoftDeletes;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    protected $fillable = [
        'uuid',
        'booking_id',
        'latitude',
        'longitude',
        'full_address',
        'zip_code',
        'address_type',
        'type',
        'order'
    ];
}
