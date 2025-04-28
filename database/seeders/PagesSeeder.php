<?php

namespace Database\Seeders;

use App\Models\{Page ,PageTranslation};
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::insert([
            ['id'=>1 , 'slug'=>'about-us' , 'created_at'=>now()],
            ['id'=>2 , 'slug'=>'privacy-policy' , 'created_at'=>now()],
            ['id'=>3 , 'slug'=>'return-policy' , 'created_at'=>now()],
            ['id'=>4 , 'slug'=>'special-order-policy' , 'created_at'=>now()],
            ['id'=>5 , 'slug'=>'terms-and-conditions', 'created_at'=>now()],
        ]);

        PageTranslation::insert([
            ['page_id'=>1 ,'locale' => 'en', 'name' => 'About Us' ,'description'=>'<p>We are a company specialized in providing the best services and solutions to our customers. Our company was founded with a clear vision aimed at meeting market needs and delivering innovative products and services that fulfill customer expectations. </p>
            <p>We strive to provide an outstanding experience for our customers through a professional team with extensive expertise. We believe that our success relies on customer satisfaction and trust, and that’s why we ensure the highest levels of quality and professionalism in everything we offer.</p>'],

            ['page_id'=>1 ,'locale' => 'ar', 'name' => 'من نحن' , 'description'=>'<p>نحن شركة متخصصة في تقديم أفضل الخدمات والحلول لعملائنا. تأسست شركتنا برؤية واضحة تهدف إلى تلبية احتياجات السوق وتقديم منتجات وخدمات مبتكرة تلبي تطلعات العملاء.</p>
            <p>نسعى جاهدين لتقديم تجربة متميزة لعملائنا من خلال فريق عمل محترف يتمتع بالخبرة والكفاءة العالية. نحن نؤمن بأن نجاحنا يعتمد على رضا عملائنا وثقتهم بنا، ولذلك نحرص على تقديم أعلى مستويات الجودة والاحترافية في كل ما نقدمه.</p>'],

            ['page_id'=>2 ,'locale' => 'en', 'name' => 'Privacy Policy' ,'description'=>'<p>Your privacy is important to us. We are committed to protecting your personal data and ensuring that your information is handled in a secure and responsible manner.</p>
            <p>Our privacy policy outlines how we collect, use, and protect your information when you use our website and services. We only collect data necessary to enhance your experience and provide the best possible service.</p>'],

            ['page_id'=>2 ,'locale' => 'ar', 'name' => 'سياسة الخصوصية' , 'description'=>'<p>خصوصيتك تهمنا. نحن ملتزمون بحماية بياناتك الشخصية وضمان التعامل مع معلوماتك بطريقة آمنة ومسؤولة.</p>
            <p>توضح سياسة الخصوصية لدينا كيفية جمع بياناتك واستخدامها وحمايتها عند استخدام موقعنا وخدماتنا. نحن نجمع فقط المعلومات الضرورية لتحسين تجربتك وتقديم أفضل خدمة ممكنة.</p>'],

            ['page_id'=>3 ,'locale' => 'en', 'name' => 'Return Policy' ,'description'=>'<p>We understand that sometimes a product may not meet your expectations. Our return policy is designed to ensure a smooth and hassle-free process for returns and exchanges.</p>
            <p>You may return or exchange items within a specified period, provided they are in their original condition. Please review our detailed return guidelines before proceeding with a return request.</p>'],

            ['page_id'=>3 ,'locale' => 'ar', 'name' => 'سياسة الاسترجاع' , 'description'=>'<p>نحن ندرك أنه في بعض الأحيان قد لا يرقى المنتج إلى توقعاتك. تم تصميم سياسة الاسترجاع لدينا لضمان عملية مريحة وسهلة للإرجاع والاستبدال.</p>
            <p>يمكنك إعادة أو استبدال المنتجات خلال فترة محددة بشرط أن تكون في حالتها الأصلية. يرجى مراجعة إرشادات الاسترجاع المفصلة قبل تقديم طلب الإرجاع.</p>'],

            ['page_id'=>4 ,'locale' => 'en', 'name' => 'Special Order Policy' ,'description'=>'<p>For customized and special orders, we require additional processing time to ensure that your product meets the highest standards.</p>
            <p>Special orders are non-refundable once confirmed. Please ensure all details are correct before placing your order. For more information, contact our support team.</p>'],

            ['page_id'=>4 ,'locale' => 'ar', 'name' => 'سياسة الطلبات الخاصة' , 'description'=>'<p>بالنسبة للطلبات المخصصة والخاصة، نحن نحتاج إلى وقت إضافي لمعالجة الطلبات وضمان توافق المنتج مع أعلى المعايير.</p>
            <p>الطلبات الخاصة غير قابلة للاسترداد بعد التأكيد. يرجى التأكد من صحة جميع التفاصيل قبل تقديم الطلب. لمزيد من المعلومات، يرجى التواصل مع فريق الدعم.</p>'],

            ['page_id'=>5 ,'locale' => 'en', 'name' => 'Terms & Conditions' ,'description'=>'<p>By using our website and services, you agree to our terms and conditions. These terms outline the rules and regulations that govern the use of our platform.</p>
            <p>We reserve the right to modify our terms at any time, so we encourage users to review them periodically. Continued use of our services constitutes acceptance of the latest version of our terms.</p>'],

            ['page_id'=>5 ,'locale' => 'ar', 'name' => 'الشروط والأحكام' , 'description'=>'<p>من خلال استخدام موقعنا وخدماتنا، فإنك توافق على الشروط والأحكام الخاصة بنا. تحدد هذه الشروط القواعد واللوائح التي تحكم استخدام منصتنا.</p>
            <p>نحتفظ بالحق في تعديل الشروط في أي وقت، لذا نشجع المستخدمين على مراجعتها بشكل دوري. استمرار استخدامك لخدماتنا يعني قبولك لأحدث نسخة من الشروط.</p>'],

        ]);
    }
}
