<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Address extends Model
{
    use HasFactory,SoftDeletes;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'phone_number',
        'full_address',
        'zip_code',
        'type',
        'is_default',
        'created_by',
        'updated_by'
    ];

    protected $casts= [
        'full_address' => 'array'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
