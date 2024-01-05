<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankDetails extends Model
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
        'first_name',
        'last_name',
        'ach',
        'account',
        'bank',
    ];

    public function agent(){
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute() {
        return $this->first_name .(!is_null($this->last_name) ?  ' ' . $this->last_name : '');
    }

}
