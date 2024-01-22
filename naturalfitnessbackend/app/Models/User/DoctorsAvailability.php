<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class DoctorsAvailability extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'doctor_id',
        'available_day',
        'available_from',
        'available_to',
        'is_active'
    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function doctor() {
        return $this->belongsTo(User::class);
    }
}
