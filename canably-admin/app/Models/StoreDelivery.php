<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreDelivery extends Model
{

    use HasFactory, SoftDeletes;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    protected $fillable= [
        'store_id',
        'uuid',
        'order_id',
        'delivery_status'
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }
}
