<?php

namespace Database\Seeders\Site;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Site\{Category, Group,Faq};

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json  = file_get_contents(database_path() . '/data/faqs.json');
        $data  = json_decode($json);
        foreach ($data->faqs as $group => $faqs) {
            $isGroupUpdateOrCreated= Category::updateOrCreate(['name'=>$group ],[
                'name'=> $group, 'type'=> 'faqs'
            ]);
            if($isGroupUpdateOrCreated){
                foreach ($faqs as $faq) {
                    Faq::updateOrCreate(['question'=>$faq->question ],[
                        'category_id'=> $isGroupUpdateOrCreated->id, 'question'=> $faq->question, 'answer'=> $faq->answer
                    ]);
                }
            }
        }
    }
}
