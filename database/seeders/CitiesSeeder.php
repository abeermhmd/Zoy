<?php

namespace Database\Seeders;

use App\Models\{City , CityTranslation};
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        // Array to store all city data
        $cityData = [];
        // Array to store all translation data
        $translationData = [];

        // Current ID counter
        $cityId = 1;

        // Updated country mappings based on your country seeder
        // country_code => country_id
        $countryMappings = [
            'KW' => 1, // Kuwait
            'BH' => 2, // Bahrain
            'OM' => 3, // Oman
            'QA' => 4, // Qatar
            'SA' => 5, // Saudi Arabia
            'AE' => 6, // United Arab Emirates
        ];

        // Define cities data
        $cities = [
            ['country_code' => 'SA', 'cities' => [
                ['name' => 'Riyadh', 'translations' => ['ar' => 'الرياض', 'en' => 'Riyadh']],
                ['name' => 'Jeddah', 'translations' => ['ar' => 'جدة', 'en' => 'Jeddah']],
                ['name' => 'Mecca', 'translations' => ['ar' => 'مكة', 'en' => 'Mecca']],
                ['name' => 'Medina', 'translations' => ['ar' => 'المدينة', 'en' => 'Medina']],
                ['name' => 'Dammam', 'translations' => ['ar' => 'الدمام', 'en' => 'Dammam']],
                ['name' => 'Khobar', 'translations' => ['ar' => 'الخبر', 'en' => 'Khobar']],
                ['name' => 'Taif', 'translations' => ['ar' => 'الطائف', 'en' => 'Taif']],
                ['name' => 'Abha', 'translations' => ['ar' => 'أبها', 'en' => 'Abha']],
                ['name' => 'Buraidah', 'translations' => ['ar' => 'بريدة', 'en' => 'Buraidah']],
                ['name' => 'Jubail', 'translations' => ['ar' => 'الجبيل', 'en' => 'Jubail']],
                ['name' => 'Najran', 'translations' => ['ar' => 'نجران', 'en' => 'Najran']],
                ['name' => 'Al-Khobar', 'translations' => ['ar' => 'الخُبر', 'en' => 'Al-Khobar']],
                ['name' => 'Al-Qassim', 'translations' => ['ar' => 'القصيم', 'en' => 'Al-Qassim']],
                ['name' => 'Khamis Mushait', 'translations' => ['ar' => 'خميس مشيط', 'en' => 'Khamis Mushait']],
                ['name' => 'Tabuk', 'translations' => ['ar' => 'تبوك', 'en' => 'Tabuk']],
                ['name' => 'Al-Mubarraz', 'translations' => ['ar' => 'المبرز', 'en' => 'Al-Mubarraz']],
                ['name' => 'Sakakah', 'translations' => ['ar' => 'سكاكا', 'en' => 'Sakakah']],
                ['name' => 'Arar', 'translations' => ['ar' => 'عرعر', 'en' => 'Arar']],
                ['name' => 'Jazan', 'translations' => ['ar' => 'جازان', 'en' => 'Jazan']],
                ['name' => 'Al-Hasa', 'translations' => ['ar' => 'الاحساء', 'en' => 'Al-Hasa']],
            ]],
            ['country_code' => 'AE', 'cities' => [
                ['name' => 'Dubai', 'translations' => ['ar' => 'دبي', 'en' => 'Dubai']],
                ['name' => 'Abu Dhabi', 'translations' => ['ar' => 'أبوظبي', 'en' => 'Abu Dhabi']],
                ['name' => 'Sharjah', 'translations' => ['ar' => 'الشارقة', 'en' => 'Sharjah']],
                ['name' => 'Ajman', 'translations' => ['ar' => 'عجمان', 'en' => 'Ajman']],
                ['name' => 'Fujairah', 'translations' => ['ar' => 'الفجيرة', 'en' => 'Fujairah']],
                ['name' => 'Ras Al Khaimah', 'translations' => ['ar' => 'رأس الخيمة', 'en' => 'Ras Al Khaimah']],
                ['name' => 'Umm Al-Quwain', 'translations' => ['ar' => 'أم القيوين', 'en' => 'Umm Al-Quwain']],
                ['name' => 'Al Ain', 'translations' => ['ar' => 'العين', 'en' => 'Al Ain']],
                ['name' => 'Khalifa City', 'translations' => ['ar' => 'مدينة خليفة', 'en' => 'Khalifa City']],
                ['name' => 'Musanah', 'translations' => ['ar' => 'المصنعة', 'en' => 'Musanah']],
            ]],
            ['country_code' => 'KW', 'cities' => [
                ['name' => 'Kuwait City', 'translations' => ['ar' => 'مدينة الكويت', 'en' => 'Kuwait City']],
                ['name' => 'Hawalli', 'translations' => ['ar' => 'حولى', 'en' => 'Hawalli']],
                ['name' => 'Mubarak Al-Kabeer', 'translations' => ['ar' => 'مبارك الكبير', 'en' => 'Mubarak Al-Kabeer']],
                ['name' => 'Salmiya', 'translations' => ['ar' => 'السالمية', 'en' => 'Salmiya']],
                ['name' => 'Fahaheel', 'translations' => ['ar' => 'الفحيحيل', 'en' => 'Fahaheel']],
                ['name' => 'Jahra', 'translations' => ['ar' => 'الجهراء', 'en' => 'Jahra']],
                ['name' => 'Abu Halifa', 'translations' => ['ar' => 'أبو حليفة', 'en' => 'Abu Halifa']],
                ['name' => 'Rigga', 'translations' => ['ar' => 'الرقعي', 'en' => 'Rigga']],
                ['name' => 'Mangaf', 'translations' => ['ar' => 'المغف', 'en' => 'Mangaf']],
                ['name' => 'Sabah Al-Salem', 'translations' => ['ar' => 'صباح السالم', 'en' => 'Sabah Al-Salem']],
            ]],
            ['country_code' => 'QA', 'cities' => [
                ['name' => 'Doha', 'translations' => ['ar' => 'الدوحة', 'en' => 'Doha']],
                ['name' => 'Al Rayyan', 'translations' => ['ar' => 'الريان', 'en' => 'Al Rayyan']],
                ['name' => 'Al Wakrah', 'translations' => ['ar' => 'الوكرة', 'en' => 'Al Wakrah']],
                ['name' => 'Al Khor', 'translations' => ['ar' => 'الخور', 'en' => 'Al Khor']],
                ['name' => 'Al Daayen', 'translations' => ['ar' => 'الذهيّن', 'en' => 'Al Daayen']],
                ['name' => 'Umm Salal', 'translations' => ['ar' => 'أم صلال', 'en' => 'Umm Salal']],
                ['name' => 'Al Shamal', 'translations' => ['ar' => 'الشمال', 'en' => 'Al Shamal']],
                ['name' => 'Al Zubara', 'translations' => ['ar' => 'الزُبارة', 'en' => 'Al Zubara']],
                ['name' => 'Mesaieed', 'translations' => ['ar' => 'مسيعيد', 'en' => 'Mesaieed']],
                ['name' => 'Lusail', 'translations' => ['ar' => 'لوسيل', 'en' => 'Lusail']],
            ]],
            ['country_code' => 'OM', 'cities' => [
                ['name' => 'Muscat', 'translations' => ['ar' => 'مسقط', 'en' => 'Muscat']],
                ['name' => 'Salalah', 'translations' => ['ar' => 'صلالة', 'en' => 'Salalah']],
                ['name' => 'Nizwa', 'translations' => ['ar' => 'نزوى', 'en' => 'Nizwa']],
                ['name' => 'Sohar', 'translations' => ['ar' => 'صُحار', 'en' => 'Sohar']],
                ['name' => 'Buraimi', 'translations' => ['ar' => 'البريمي', 'en' => 'Buraimi']],
                ['name' => 'Sur', 'translations' => ['ar' => 'صور', 'en' => 'Sur']],
                ['name' => 'Ibra', 'translations' => ['ar' => 'إبراء', 'en' => 'Ibra']],
                ['name' => 'Rustaq', 'translations' => ['ar' => 'الرستاق', 'en' => 'Rustaq']],
                ['name' => 'Dhofar', 'translations' => ['ar' => 'ظفار', 'en' => 'Dhofar']],
                ['name' => 'Khasab', 'translations' => ['ar' => 'خصب', 'en' => 'Khasab']],
            ]],
            ['country_code' => 'BH', 'cities' => [
                ['name' => 'Manama', 'translations' => ['ar' => 'المنامة', 'en' => 'Manama']],
                ['name' => 'Madinat Hamad', 'translations' => ['ar' => 'مدينة حمد', 'en' => 'Madinat Hamad']],
                ['name' => 'Riffa', 'translations' => ['ar' => 'الرفاع', 'en' => 'Riffa']],
                ['name' => 'Muharraq', 'translations' => ['ar' => 'المحرّق', 'en' => 'Muharraq']],
                ['name' => 'Isa Town', 'translations' => ['ar' => 'مدينة عيسى', 'en' => 'Isa Town']],
                ['name' => 'Sitra', 'translations' => ['ar' => 'سترة', 'en' => 'Sitra']],
                ['name' => 'Budaiya', 'translations' => ['ar' => 'البدع', 'en' => 'Budaiya']],
                ['name' => 'Jidhafs', 'translations' => ['ar' => 'جدحفص', 'en' => 'Jidhafs']],
                ['name' => 'Zallaq', 'translations' => ['ar' => 'زلاق', 'en' => 'Zallaq']],
            ]],
        ];

        // Process each country and its cities
        foreach ($cities as $country) {
            $countryId = $countryMappings[$country['country_code']];

            foreach ($country['cities'] as $city) {
                // Add city to cityData array
                $cityData[] = [
                    'id' => $cityId,
                    'country_id' => $countryId,
                    'delivery_fees' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Add translations to translationData array
                foreach ($city['translations'] as $locale => $name) {
                    $translationData[] = [
                        'city_id' => $cityId,
                        'locale' => $locale,
                        'name' => $name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Increment city ID for next city
                $cityId++;
            }
        }

        // Insert all cities
        City::insert($cityData);

        // Insert all translations
        CityTranslation::insert($translationData);
    }
}
