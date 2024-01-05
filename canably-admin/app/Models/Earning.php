<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Earning extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable= [
        'agent_id',
        'customer_id',
        'transaction_no',
        'transactioned_at',
        'amount',
        'is_approve',
    ];

    public function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }
    public function customer(){
        return $this->belongsTo(User::class,'customer_id');
    }
}
