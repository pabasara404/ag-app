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
        Schema::create('samurdhi_details', function (Blueprint $table) {
            $table->id();
            $table->string('subside_amount');
            $table->string('is_subsidiaries_returned')->default(false);
            $table->text('recommendation');
            $table->date('checked_date');
            $table->timestamps();
            $table->foreignId('income_certificate_id')->references('id')->on('income_certificates')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samurdhi_details');
    }
};
