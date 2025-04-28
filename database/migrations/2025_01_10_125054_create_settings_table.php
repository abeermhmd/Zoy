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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->string('info_email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('whatsApp')->nullable();
            $table->string('area')->nullable();
            $table->string('block')->nullable();
            $table->string('street')->nullable();
            $table->string('address')->nullable();
            $table->string('map_location_pinpoint')->nullable();
            $table->string('instagram')->nullable();
            $table->string('banner_ad_image')->nullable();
            $table->integer('type_link')->default(1)->comment('1->nothing , 2->product , 3->category , 4->subcategory');
            $table->integer('linked_id')->nullable();
            $table->string('ad_popUp_image')->nullable();
            $table->integer('type_link_pop')->default(1)->comment('1->nothing , 2->product , 3->category , 4->subcategory');
            $table->integer('linked_id_pop')->nullable();
            $table->float('tax_percent')->default(0);
            $table->float('app_percent')->default(0);
            $table->float('BHD')->default(0);
            $table->float('OMR')->default(0);
            $table->float('QAR')->default(0);
            $table->float('SAR')->default(0);
            $table->float('AED')->default(0);
            $table->integer('dashboard_paginate')->default(20);
            $table->integer('website_paginate')->default(20);
            $table->integer('is_maintenance_mode')->default(1)->comment('0=no 1= yes');
            $table->integer('is_alowed_register')->default(1)->comment('0=no 1= yes');
            $table->integer('is_alowed_login')->default(1)->comment('0=no 1= yes');
            $table->integer('is_alowed_order')->default(1)->comment('0=no 1= yes');
            $table->integer('is_alowed_subscription')->default(1)->comment('0=no 1= yes');
            $table->integer('remember_continue_order')->default(1)->comment('this equal num of days');
            $table->integer('remember_abandoned_cart')->default(1)->comment('this equal num of days');
            $table->text('seo_in_body')->nullable();
            $table->text('seo_in_header')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
