<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Webpatser\Uuid\Uuid;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'uuid',
        'user_id',
        'latitude',
        'longitude',
        'full_address',
        'zip_code',
        'type',
        'is_default'
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
}
