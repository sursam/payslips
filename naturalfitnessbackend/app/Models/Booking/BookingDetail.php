<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class BookingDetail extends Model
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
        'doctor_level_id',
        'booking_for',
        'relationship',
        'mobile_number',
        'partner_info',
        'other_info',
        'consultaion_type',
        'survey_results'
    ];
    protected $casts = [
        'partner_info' => 'array',
        'survey_results' => 'array'
    ];
}
