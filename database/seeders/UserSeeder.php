<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'saji',
            'email'=>'saji@gmail.com',
            'mobile'=>'96577777777',
            'date_of_birth'=>'1995-02-12',
            'password'=> Hash::make(123456)
            ,
        ]);
        // User::factory(20)->create();

    }
}
