<?php

namespace Database\Seeders\Site;

use App\Models\Site\{Category,Attribute};
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json  = file_get_contents(database_path() . '/data/categories.json');
        $data  = json_decode($json);
        foreach ($data->categories as $value) {
            Category::updateOrCreate(['name'=>$value->name ],[
                'name'=> $value->name,
                'alias'=> $value->alias ?? null,
                'type'=> $value->type ?? null,
            ]);
        }
    }
}
