<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Permission;
class Role extends Model
{

    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable =[
        'name',
        'short_code',
        'role_type'
    ];


    public function permissions() {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }

    public function getAllPermissions(array $permissions){
        return Permission::whereIn('slug',$permissions)->get();
    }

    public function hasPermission($permission){
        return (bool) $this->permissions->where('slug', $permission)->count();
    }

    public function givePermissionsTo($permissions){
        // dd($permissions);
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }
}
