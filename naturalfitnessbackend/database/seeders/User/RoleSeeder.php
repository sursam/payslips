<?php

namespace Database\Seeders\User;

use App\Models\User\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json  = file_get_contents(database_path().'/data/roles.json');
        $data  = json_decode($json);
        foreach ($data->roles as $key => $value) {
            Role::updateOrCreate([
                'name'=> $value->name
            ]);
        }
    }
}
