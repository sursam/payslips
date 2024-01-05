<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable= [
        'uuid',
        'sku',
        'product_id',
        'unit',
        'is_discontinued'
    ];

    public static function boot(){
        parent::boot();
        self::creating(function ($model) {
            $model->sku = 'SKU-'.rand(6,12);
        });
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
