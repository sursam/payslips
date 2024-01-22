<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MembershipPrice extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable= [
        'uuid',
        'membership_id',
        'price',
        'duration',
        'interval',
    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });

    }

    public function package():BelongsTo{
        return $this->belongsTo(Membership::class);
    }
}
