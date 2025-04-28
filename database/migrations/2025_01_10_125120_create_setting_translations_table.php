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
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->constrained('settings' , 'id')->cascadeOnDelete();
            $table->string('locale')->nullable();
            $table->string('title')->nullable();
            $table->text('shipping_content_kuwait')->nullable()->comment('this exist in shipping management section');
            $table->text('shipping_content_outside_kuwait')->nullable()->comment('this exist in shipping management section');
            $table->text('instagram_text_footer')->nullable()->comment('this exist in footer website');
            $table->text('key_words')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_translations');
    }
};
