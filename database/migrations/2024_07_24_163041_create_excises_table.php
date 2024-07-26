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
        Schema::create('excises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('nic');
            $table->string('contact_number');
            $table->string('business_name');
            $table->date('issued_date');
            $table->date('expire_date');
            $table->foreignId('gn_division_id')->nullable()->references('id')->on('gn_divisions');
            $table->string('status')->default('Active');
            $table->timestamp('submission_timestamp');
            $table->text('comment')->nullable();
            $table->string('application_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excises');
    }
};
