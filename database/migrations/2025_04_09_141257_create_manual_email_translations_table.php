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
        Schema::create('manual_email_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manual_email_id')->constrained('manual_emails','id')->cascadeOnDelete();
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
        Schema::dropIfExists('manual_email_translations');
    }
};
