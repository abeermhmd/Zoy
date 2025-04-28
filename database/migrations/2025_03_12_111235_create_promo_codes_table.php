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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->unique();
            $table->integer('discount_percentage')->default(0);
            $table->integer('number_remaining_uses')->default(0);
            $table->integer('maximum_usage')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('all_countries')->default(0)->comment('if 1 for all countries, else 1 selected multi country(اذا كان 1 فسيكون مواد محددة موجودة في الجدول الاخر promo code countries)');
            $table->enum('status' , ['active' , 'not_active'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
