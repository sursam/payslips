<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Referral extends Model
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
        'mobile_number',
        'ibd_number',
        'category_id',
        'type'
    ];
    public function referredUser() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function referencePlatform() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
