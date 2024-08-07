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
        Schema::create('director_details', function (Blueprint $table) {
            $table->id();
            $table->string('registration_no');
            $table->string('business_name');
            $table->foreignId('individual_business_id')->nullable()->references('id')->on('individual_businesses');
            $table->foreignId('partner_id')->nullable()->references('id')->on('partners');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('director_details');
    }
};
