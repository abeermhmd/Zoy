<?php

namespace Database\Seeders;

use App\Models\EmailText;
use App\Models\EmailTextTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        EmailText::insert([
            ['id' => 1, 'type' => 'Order_status_updated', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'type' => 'Uncompleted_orders', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'type' => 'Birthday', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'type' => 'After_Registration', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'type' => 'abandoned_cart', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'type' => 'continue_order', 'created_at' => now(), 'updated_at' => now()],

        ]);

        EmailTextTranslation::insert([

            ['email_text_id' => 1, 'locale' => 'en', 'subject' => 'Order status updated', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],
            ['email_text_id' => 1, 'locale' => 'ar', 'subject' => 'تغير حالة الطلب', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],

            ['email_text_id' => 2, 'locale' => 'en', 'subject' => 'Cancelled Order', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],
            ['email_text_id' => 2, 'locale' => 'ar', 'subject' => 'طلب ملغي', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],

            ['email_text_id' => 3, 'locale' => 'en', 'subject' => 'Birthday', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],
            ['email_text_id' => 3, 'locale' => 'ar', 'subject' => 'يوم الميلاد', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],

            ['email_text_id' => 4, 'locale' => 'en', 'subject' => 'After Registration', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],
            ['email_text_id' => 4, 'locale' => 'ar', 'subject' => 'رسالة ترحيبية', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],

            ['email_text_id' => 5, 'locale' => 'en', 'subject' => 'abandoned cart', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],
            ['email_text_id' => 5, 'locale' => 'ar', 'subject' => 'سلة متروكة', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],

            ['email_text_id' => 6, 'locale' => 'en', 'subject' => 'continue order', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],
            ['email_text_id' => 6, 'locale' => 'ar', 'subject' => 'اكمال الطلب', 'content' => '<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering . </p>'],

        ]);
    }
}
