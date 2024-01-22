<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seo extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'body' => 'array'
    ];

    /**
     * Get all of the models that own seos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function seoable():MorphTo
    {
        return $this->morphTo();
    }
}
