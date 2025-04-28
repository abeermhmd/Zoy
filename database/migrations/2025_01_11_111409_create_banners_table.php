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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->integer('type')->default(1)->comment('1->image , 2->video');
            $table->integer('type_link')->default(1)->comment('1->nothing , 2->product , 3->category , 4->subcategory');
            $table->integer('linked_id')->nullable();
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
        Schema::dropIfExists('banners');
    }
};
