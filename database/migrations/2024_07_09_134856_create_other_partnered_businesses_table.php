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
        Schema::create('other_partnered_businesses', function (Blueprint $table) {
            $table->id();
            $table->string('registration_no');
            $table->string('business_name');
            $table->string('nature');
            $table->date('registered_date')->nullable();
            $table->foreignId('partner_id')->nullable()->references('id')->on('partners')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_partnered_businesses');
    }
};
