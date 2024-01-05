<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function media(){
        return $this->morphMany(Media::class,'mediaable');
    }

    protected function testimonialImage($type='original'){
        $file= $this->media()->first()?->file;
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/product/' . $file))){
                    return asset('storage/images/' . $type . '/product/' . $file);
                }
            }
        }
        return asset('assets/admin/images/logo.png');
    }

    public function getDisplayImageAttribute(){
        return $this->testimonialImage('original');
    }

    protected $fillable = [
        'uuid',
        'name',
        'product',
        'comment',
        'is_active'
    ];
}
