<?php

namespace App\Models\Booking;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingDriver extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'uuid',
        'booking_id',
        'user_id',
        'comment',
        'status'
    ];
    public function driver():BelongsTo {
        return $this->belongsTo(User::class,'user_id');
    }
}
