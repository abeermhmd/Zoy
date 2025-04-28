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
        Schema::create('size_translations', function (Blueprint $table) {
             $table->id();
             $table->foreignId('size_id')->constrained('sizes','id')->cascadeOnDelete();
             $table->string('locale')->nullable();
             $table->string('name')->nullable();
             $table->timestamps();
             $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_translations');
    }
};
