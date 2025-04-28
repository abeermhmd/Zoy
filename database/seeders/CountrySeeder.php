<?php

namespace Database\Seeders;

use App\Models\{Country , CountryTranslation};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Country::insert([
            ['id'=>1  , 'created_at'=>now()],
            ['id'=>2  , 'created_at'=>now()],
            ['id'=>3  , 'created_at'=>now()],
            ['id'=>4  , 'created_at'=>now()],
            ['id'=>5  , 'created_at'=>now()],
            ['id'=>6  , 'created_at'=>now()],
         ]);
         CountryTranslation::insert([
            ['country_id'=> 1 ,'locale' => 'en', 'name' => 'Kuwait' , 'created_at'=>now()],
            ['country_id'=> 1 ,'locale' => 'ar', 'name' => 'الكويت ' , 'created_at'=>now()],

            ['country_id'=> 2 ,'locale' => 'en', 'name' => 'Bahrain' , 'created_at'=>now()],
            ['country_id'=> 2 ,'locale' => 'ar', 'name' => 'البحرين ' , 'created_at'=>now()],

            ['country_id'=> 3 ,'locale' => 'en', 'name' => 'Oman' , 'created_at'=>now()],
            ['country_id'=> 3 ,'locale' => 'ar', 'name' => 'عُمان ' , 'created_at'=>now()],

            ['country_id'=> 4 ,'locale' => 'en', 'name' => 'Qatar' , 'created_at'=>now()],
            ['country_id'=> 4 ,'locale' => 'ar', 'name' => 'قطر' , 'created_at'=>now()],

            ['country_id'=> 5 ,'locale' => 'en', 'name' => 'Saudi Arabia' , 'created_at'=>now()],
            ['country_id'=> 5 ,'locale' => 'ar', 'name' => 'السعودية' , 'created_at'=>now()],

            ['country_id'=> 6,'locale' => 'en', 'name' => 'United Arab Emirates' , 'created_at'=>now()],
            ['country_id'=> 6 ,'locale' => 'ar', 'name' => 'الإمارات' , 'created_at'=>now()],

         ]);
    }
}
