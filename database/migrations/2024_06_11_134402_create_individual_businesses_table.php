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
        Schema::create('individual_businesses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('business_name');
            $table->string('nature');
            $table->string('principal_place');
            $table->string('initial_capital');
            $table->date('start_date');
            $table->string('is_other_business_value');
            $table->string('is_director');
            $table->string('other_business_name');
            $table->string('government_officer_checked_value');
            $table->string('contact_number');
            $table->string('ownership_of_land_checked_value');
            $table->date('checked_date');
//            $table->timestamps('checked_time');
            $table->foreignId('owner_detail_id')->nullable()->references('id')->on('owner_details');
            $table->foreignId('citizen_id')->nullable()->references('id')->on('citizens');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_businesses');
    }
};
