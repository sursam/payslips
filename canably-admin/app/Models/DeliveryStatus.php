<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryStatus extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =[
        'uuid',
        'order_id',
        'is_completed',
        'rejected_at',
        'accepted_at',
        'user_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function agent(){
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute(){
        return (!$this->rejected_at) ? true : false;
    }
}
