<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MembershipValidity extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable= [
        'uuid',
        'user_id',
        'member_type',
        'member_id',
        'package_code',
        'start_date',
        'end_date',
        'is_expired'
    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function memberable():MorphTo{
        return $this->morphTo();
    }
}
