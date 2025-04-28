<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //   User::factory(10)->create();
         $this->call(UserSeeder::class);
         $this->call(AdminSeeder::class);
         $this->call(SettingsSeeder::class);
         $this->call(PagesSeeder::class);
         $this->call(languagesSeeder::class);
         $this->call(CountrySeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(EmailTextSeeder::class);

    }
}
