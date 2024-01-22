<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZonePostcode extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $fillable = [
        'zone_id',
        'postcode',
        'latitude',
        'longitude',
        'place_id',
        'is_active'
    ];
    public static function boot() {
        parent::boot();
    }
}
