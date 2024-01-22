<?php

namespace App\Models\Fare;

use App\Models\Site\Category;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fare extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'start_at' => 'datetime:H:i',
        'end_at' => 'datetime:H:i'
    ];
    protected $guarded = ['id'];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
