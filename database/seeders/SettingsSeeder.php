<?php

namespace Database\Seeders;

use App\Models\{Setting ,SettingTranslation};
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'info_email'=>'info@zoy.com',
            'mobile'=>'972592123488',
            'whatsApp'=>'972592123488',
            'instagram'=>'https://instagram.com/',
            'BHD'=>'1.22',
            'OMR'=>'1.25',
            'QAR'=>'11.82',
            'SAR'=>'12.19',
            'AED'=>'11.94',
            'area'=>'area',
            'block'=>'block',
            'street'=>'street',
            'address'=>'address',
            'map_location_pinpoint'=>'https://www.google.com/maps/@29.3661696,47.9805656,14z?entry=ttu&g_ep=EgoyMDI1MDMwNC4wIKXMDSoASAFQAw%3D%3D',
            'dashboard_paginate'=>20,
            'website_paginate'=>20,
            'is_maintenance_mode'=>0,
            'is_alowed_register'=>0,
            'is_alowed_login'=>0,
        ]);

        SettingTranslation::insert([
            ['setting_id'=>1 ,'locale' => 'en', 'title' => 'Zoy Store' ,'shipping_content_kuwait'=>'shipping content
            kuwait' ,'shipping_content_outside_kuwait' => 'Shipping Content Outside Kuwait'],
            ['setting_id'=>1 ,'locale' => 'ar', 'title' => 'متجر زوي' ,'shipping_content_kuwait'=>'محتوى الشحن في
            الكويت' ,'shipping_content_outside_kuwait' => 'محتوى الشحن خارج الكويت'],
        ]);

    }
}
