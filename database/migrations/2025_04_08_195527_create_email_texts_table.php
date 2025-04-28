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
        Schema::create('email_texts', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['active', 'not_active'])->default('active');
            $table->enum('type', ['Order_status_updated','Uncompleted_orders','After_Registration','Birthday','abandoned_cart','continue_order'])->default('Order_status_updated');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_texts');
    }
};
