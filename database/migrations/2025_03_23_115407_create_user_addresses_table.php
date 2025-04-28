<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('city_id')->nullable()->comment('if Kuwait Area else city');
            $table->string('title')->nullable();
            $table->string('address_line_one')->nullable()->comment('if Kuwait Block/Street/Avenue else Address Line
            1');
            $table->string('address_line_two')->nullable()->comment('if Kuwait Building No/Floor/Apartment Number else
            Address Line 2');
            $table->string('extra_directions')->nullable();
            $table->string('postal_code')->nullable()->comment('if country not Kuwait');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
