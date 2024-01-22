<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        self::softDeleted(function ($model) {
            $model->price()->delete();
        });
    }

    protected $fillable= [
        'uuid',
        'membership_type',
        'name',
        'badge',
        'is_most_popular',
        'description',
        'package_attributes',
        'is_active'
    ];


    public function price():HasOne{
        return $this->hasOne(MembershipPrice::class);
    }

    public function subscribedUsers():MorphMany{
        return $this->morphMany(MembershipValidity::class,'memberable');
    }


}
