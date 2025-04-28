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
        Schema::create('email_text_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_text_id')->constrained('email_texts','id')->cascadeOnDelete();
            $table->string('locale')->nullable();
            $table->string('subject')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_text_translations');
    }
};
