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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('source_of_income');
            $table->string('registration_no');
            $table->string('name');
            $table->string('size');
            $table->string('monthly_income');
            $table->string('annual_income');
            $table->timestamps();
            $table->foreignId('income_certificate_id')->references('id')->on('income_certificates')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
