<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Faq;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['home','Home','Welcome to Createlize Bazaar'],
            ['about','About','About Createlize Bazaar'],
            ['contact','Contact','Contact us'],
            ['services','Services','Our services'],
            ['refund','Refund Policy','Refund policy content'],
            ['terms','Terms & Conditions','Terms content'],
        ] as $p) {
            Page::updateOrCreate(['key'=>$p[0]], ['title'=>$p[1],'content'=>$p[2],'meta'=>['lang'=>['bn','en']]]);
        }

        Faq::updateOrCreate(['question'=>'How delivery works?'], ['answer'=>'Delivery depends on delivery type.','is_active'=>true,'sort_order'=>1]);
    }
}
