<?php

namespace App\Models\Company;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialQuestion extends Model
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


    public function twoYearsAgo()
    {
        return $this->belongsTo(FinancialYear::class, 'two_year_ago_info_id');
    }
    public function oneYearsAgo()
    {
        return $this->belongsTo(FinancialYear::class, 'one_year_ago_info_id');
    }
    public function currentYears()
    {
        return $this->belongsTo(FinancialYear::class, 'current_year_info_id');
    }
    public function oneYearsBefore()
    {
        return $this->belongsTo(FinancialYear::class, 'one_year_before_info_id');
    }
    public function twoYearsBefore()
    {
        return $this->belongsTo(FinancialYear::class, 'two_year_before_info_id');
    }
}
