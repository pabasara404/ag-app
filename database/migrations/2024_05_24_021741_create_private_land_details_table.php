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
        Schema::create('private_land_details', function (Blueprint $table) {
            $table->id();
            $table->string('land_deed_number');
            $table->date('registration_date');
            $table->string('plan_plot_number');
            $table->string('registration_office');
            $table->string('plan_number');
            $table->string('land_name');
            $table->string('land_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_land_details');
    }
};
