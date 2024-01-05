<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        'id'
    ];

    protected $fillable = [
        'uuid',
        'user_id',
        'order_no',
        'delivery_type',
        'discount',
        'delivery_otp',
        'delivery_status',
        'status_description',
        'delivered_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status_description'=>'array'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
            $model->order_no = (string) 'OD-' . random_int(8, 15) . time();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryStatus(){
        return $this->hasOne(DeliveryStatus::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function orderAddress()
    {
        return $this->hasOne(OrderAddress::class);
    }
    public function orderTransaction()
    {
        return $this->hasOne(Transaction::class);
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
    public function orderStore()
    {
        return $this->hasOne(StoreDelivery::class);
    }

    public function coupons(){
        return $this->belongsToMany(Coupon::class,'orders_coupons');
    }

    public function earning(){
        return $this->hasOne(Earning::class);
    }

    /* public function scopeDelivery($query)
    {

        return $query
            ->when($this->delivery_type === 'store_pick', function ($q) {
                return $q->with('orderStore');
            },function($q){
                return $q->with('orderAddress');
            });
    } */

}
