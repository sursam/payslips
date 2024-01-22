<?php

namespace Database\Seeders\Site;

use App\Models\Site\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json  = file_get_contents(database_path() . '/data/brands.json');
        $data  = json_decode($json);
        foreach ($data->brands as $key => $value) {
            Brand::updateOrCreate(['name'=>$value->name ],[
                'name'=> $value->name
            ]);
        }

    }
}
