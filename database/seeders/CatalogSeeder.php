<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DeliveryField;
use App\Models\DeliveryType;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $cat1 = Category::create(['name'=>'Subscriptions','slug'=>'subscriptions','sort_order'=>1]);
        $sub1 = SubCategory::create(['category_id'=>$cat1->id,'name'=>'AI Subscriptions','slug'=>'ai-subscriptions','sort_order'=>1]);

        $cat2 = Category::create(['name'=>'Digital Products','slug'=>'digital-products','sort_order'=>2]);
        $sub2 = SubCategory::create(['category_id'=>$cat2->id,'name'=>'Courses','slug'=>'courses','sort_order'=>1]);

        $online = DeliveryType::create(['name'=>'Online Delivery (Not Instant)','key'=>'online','sort_order'=>1]);
        $instant = DeliveryType::create(['name'=>'Instant Delivery','key'=>'instant','sort_order'=>2]);
        $physical = DeliveryType::create(['name'=>'Physical Delivery (Prepaid)','key'=>'physical_prepaid','sort_order'=>3]);
        $cod = DeliveryType::create(['name'=>'Cash On Delivery (COD)','key'=>'cod','sort_order'=>4]);

        // Default fields per delivery type
        foreach ([
            [$online, ['Gmail','gmail','email',true,'Your Gmail for delivery',[]]],
            [$online, ['Phone','phone','phone',false,'01XXXXXXXXX',[]]],
            [$instant, ['Gmail','gmail','email',true,'Your Gmail for delivery',[]]],
            [$physical, ['Full Address','address','textarea',true,'House, Road, Area',[]]],
            [$physical, ['Phone','phone','phone',true,'01XXXXXXXXX',[]]],
            [$cod, ['Full Address','address','textarea',true,'House, Road, Area',[]]],
            [$cod, ['Phone','phone','phone',true,'01XXXXXXXXX',[]]],
        ] as $idx => $row) {
            [$dt, $arr] = $row;
            DeliveryField::create([
                'delivery_type_id'=>$dt->id,
                'title'=>$arr[0],
                'name'=>$arr[1],
                'type'=>$arr[2],
                'required'=>$arr[3],
                'placeholder'=>$arr[4],
                'options'=>$arr[5],
                'sort_order'=>$idx+1
            ]);
        }

        $vendor1 = User::where('email','vendor1@createlize.org')->first();
        $vendor2 = User::where('email','vendor2@createlize.org')->first();

        Product::create([
            'vendor_id'=>$vendor1->id,
            'category_id'=>$cat1->id,
            'sub_category_id'=>$sub1->id,
            'delivery_type_id'=>$online->id,
            'name'=>'ChatGPT Go 1 Year',
            'slug'=>'chatgpt-go-1-year',
            'title'=>'ChatGPT Go (1 Year)',
            'description'=>'Non-instant delivery. Admin will deliver later.',
            'price'=>150,
            'discount_percent'=>0,
            'currency'=>'BDT',
            'stock'=>null,
            'sku'=>'CGO-1Y',
            'tags'=>['chatgpt','subscription'],
            'meta'=>['language'=>['bn','en']],
            'is_active'=>true,
            'is_featured'=>true,
        ]);

        Product::create([
            'vendor_id'=>$vendor1->id,
            'category_id'=>$cat2->id,
            'sub_category_id'=>$sub2->id,
            'delivery_type_id'=>$instant->id,
            'name'=>'ChatGPT Go Course',
            'slug'=>'chatgpt-go-course',
            'title'=>'ChatGPT Go Course',
            'description'=>'Instant delivery demo product.',
            'price'=>1500,
            'discount_percent'=>10,
            'currency'=>'BDT',
            'sku'=>'CGC-001',
            'tags'=>['course'],
            'meta'=>[],
            'is_active'=>true,
            'is_featured'=>false,
        ]);
    }
}
