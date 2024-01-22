<?php

namespace App\Models\User;

use Webpatser\Uuid\Uuid;
use App\Models\User\User;
use App\Models\Site\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'uuid',
        'user_id',
        'balance',
        'status'
    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactions():MorphMany{
        return $this->morphMany(Transaction::class,'transactionable');
    }

}
