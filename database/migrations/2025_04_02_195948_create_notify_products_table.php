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
        Schema::create('notify_products', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('color_id')->nullable();
            $table->integer('size_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notify_products');
    }
};
