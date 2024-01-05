<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class OrderAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'order_id ',
        'name',
        'phone_number',
        'full_address',
        'zip_code',
        'created_by',
        'updated_by',
    ];

    protected $casts= [
        'full_address'=> 'array'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getShipperNameAttribute(){
        return ($this->full_address['first_name'] ?? $this->order->user->first_name) .' '. ($this->full_address['last_name'] ?? $this->order->user->last_name);
    }
}
