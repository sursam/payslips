<?php

namespace App\Models\Company;

use App\Models\Location\City;
use App\Models\Location\State;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Location extends Model
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
        'company_id',
        'country_id',
        'state_id',
        'zipcode',
        'city_id',
        'trading_address',
        'street_address',
        'is_active',       
    ];

    public function state():HasOne{
        return $this->hasOne(State::class, 'id', 'state_id');
    }
    public function city():HasOne{
        return $this->hasOne(City::class, 'id', 'city_id');
    }

}
