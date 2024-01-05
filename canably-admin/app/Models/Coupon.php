<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Coupon extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'uuid',
        'title',
        'code',
        'coupon_type',
        'category_id',
        'coupon_discount',
        'usage_per_user',
        'usage_of_coupon',
        'started_at',
        'ended_at',
        'is_expired',
        'is_active',
        'created_by',
        'updated_by'

    ];
    public static function boot(){
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'coupons_categories');
    }

    public function users(){
        return $this->belongsToMany(User::class,'users_coupons');
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'orders_coupons');
    }
}
