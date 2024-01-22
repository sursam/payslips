<?php

namespace Database\Seeders\Site;

use App\Models\Site\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json  = file_get_contents(database_path() . '/data/tags.json');
        $data  = json_decode($json);
        foreach ($data->tags as $key => $value) {
            $attributeCreated= Tag::updateOrCreate(['name'=>$value->name ],[
                'name'=> $value->name
            ]);
        }
    }
}
