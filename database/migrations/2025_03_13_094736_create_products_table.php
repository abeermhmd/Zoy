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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('sku')->nullable()->comment('رمز المنتج (SKU - Stock Keeping Unit)');
            $table->float('price')->default(0);
            $table->float('price_offer')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('remaining_quantity')->default(0);
            $table->integer('category_id')->nullable()->comment('ids for subcategories + categories dont include subcategories');
            $table->double('weight')->nullable()->comment('in kg');
            $table->string('size_guide_image')->nullable();
            $table->integer('most_selling')->default(0)->comment('0->off , 1->on');
            $table->integer('new_arrival')->default(0)->comment('0->off , 1->on');
            $table->integer('has_variants')->default(0)->comment('0->off , 1->on');
            $table->integer('type_variants')->default(0)->comment('0->no variants , 1->mix , 2->only colors , 3->only
            sizes .(this for quantites section)');
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
        Schema::dropIfExists('products');
    }
};
