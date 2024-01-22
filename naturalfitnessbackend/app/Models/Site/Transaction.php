<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use App\Models\User\User;
use App\Models\User\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
            $model->transaction_no = 'tr-'.time();
        });
    }

    protected $fillable = [
        'uuid',
        'order_id',
        'user_id',
        'amount',
        'transactionable_type',
        'transactionable_id',
        'currency',
        'type',
        'payment_gateway',
        'payment_gateway_id',
        'payment_gateway_uuid',
        'json_response',
        'status',
    ];

    protected $casts= [
        'json_response' => 'array'
    ];

    public function transactionable():MorphTo{
        return $this->morphTo();
    }

    public function order():BelongsTo{
        return $this->belongsTo(Order::class);
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
