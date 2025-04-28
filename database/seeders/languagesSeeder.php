<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\LanguageTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class languagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::insert([
            ['id'=>1 , 'lang'=>'en' , 'created_at'=>now()],
            ['id'=>2 , 'lang'=>'ar' , 'created_at'=>now()],
        ]);

        LanguageTranslation::insert([
            ['id'=>1 ,'language_id'=> 1, 'locale'=>'en' ,'name'=>'English', 'created_at'=>now()],
            ['id'=>2 ,'language_id'=> 1,'locale'=>'ar' ,'name'=>'انجليزي', 'created_at'=>now()],
            ['id'=>3 ,'language_id'=> 2, 'locale'=>'en' ,'name'=>'Arabic', 'created_at'=>now()],
            ['id'=>4 ,'language_id'=> 2, 'locale'=>'ar' ,'name'=>'عربي', 'created_at'=>now()],
        ]);

    }
}
