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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
             $table->foreignId('parent_id')->nullable();
            //  ->constrained('categories' ,'id') ///relation with categories table by column id
            //  ->nullOnDelete(); ///عندما نقوم بحدف الاب يتم وضع هذا الحقل فارغ
             // ->cascadeOnDelete()/////اذا حذفت الاب يتم حذف الابناء
             // ->restrictOnDelete();///// اذا كنت بدي احذف الاب وله ابناء لا يسمح وهاي الديفولت
            $table->string('image')->nullable();
            $table->float('discount')->default(0);
            $table->enum('department',['women' , 'man'])->nullable();
            $table->enum('is_featured',['yes' , 'no'])->default('no');
            $table->enum('status',['active','not_active'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
