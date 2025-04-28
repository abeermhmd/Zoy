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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('user_key')->nullable();
            $table->float('total')->nullable();
            $table->float('sub_total')->nullable();
            $table->float('delivery_fees')->nullable();
            $table->string('discount_code')->nullable();
            $table->float('discount')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->integer('payment_status')->default(0)->comment('0->not paid , 1->paid');
            $table->integer('payment_method')->nullable()->comment('1->knet , 2->visa , 3->Mastercard ,4->Apple pay , 5->Samsung pay');
            $table->text('payment_json')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('InvoiceReference')->nullable();
            $table->text('payment_check_response')->nullable();
            $table->string('payment_id')->nullable();
            $table->integer('address_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('address_line_one')->nullable();
            $table->string('address_line_two')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('extra_directions')->nullable();
            $table->integer('status')->default(0)->comment('0->Placed , 1->On the Way , 2->Delivered , 3->Canceled');
            $table->integer('count_products')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
