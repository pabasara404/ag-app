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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('previous_name')->nullable();
            $table->string('government_officer_checked_value');
            $table->string('nationality');
            $table->string('nic');
            $table->string('contact_number');
            $table->string('residence');
            $table->boolean('is_other_occupation_value')->default(false);
            $table->string('occupation')->nullable();
            $table->boolean('is_other_business_value')->default(false);
            $table->boolean('is_director')->default(false);
            $table->foreignId('firm_id')->nullable()->references('id')->on('firms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
