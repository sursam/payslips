<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions= Permission::get();
        $json  = file_get_contents(database_path() . '/data/roles.json');
        $data  = json_decode($json);
        $permissions= Permission::get();
        foreach ($data->roles as $key => $value) {
            Role::updateOrCreate([
                'name'=> $value->name,
                'short_code'=> $value->short_code,
                'role_type'=> $value->role_type
            ]);
        }
        $role= Role::find(1);
        $role->permissions()->attach($permissions);
    }
}
