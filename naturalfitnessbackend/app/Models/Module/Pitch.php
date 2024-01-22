<?php

namespace App\Models\module;

use App\Models\Company\Company;
use App\Models\Company\InitialEnquiry;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pitch extends Model
{
    use HasFactory, SoftDeletes;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    protected $guarded = [];

    public function company() {
        return $this->belongsTo(Company::class);
    } 
    public function initial_enquiry() {
        return $this->belongsTo(InitialEnquiry::class,'step_one_id');
    } 
}
