<?php

namespace App\Models\Booking;

use App\Models\Medical\Issue;
use Webpatser\Uuid\Uuid;
use App\Models\Site\Category;
use App\Models\Site\PaymentMode;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Http;

class Booking extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        self::softDeleted(function ($model) {
            $model->details->delete();
        });
    }

    protected $fillable = [
        'uuid',
        'patient_id',
        'doctor_id',
        'issue_id',
        'booking_datetime',
        'status',
        'payment_mode_id',
        'price',
        'verification_code'
    ];

    protected $casts = [
        'booking_datetime' =>'datetime'
    ];

    public function paymentMode():BelongsTo{
        return $this->belongsTo(PaymentMode::class,'payment_mode_id');
    }
    public function customer():BelongsTo {
        return $this->BelongsTo(User::class,'user_id');
    }
    public function addresses():HasMany {
        return $this->hasMany(BookingAddress::class);
    }

    public function details():HasOne {
        return $this->hasOne(BookingDetail::class);
    }
    public function patient():BelongsTo {
        return $this->BelongsTo(User::class,'patient_id');
    }
    public function doctor():BelongsTo {
        return $this->BelongsTo(User::class,'doctor_id');
    }
    public function issue():BelongsTo {
        return $this->BelongsTo(Issue::class,'issue_id');
    }
}
