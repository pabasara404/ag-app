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
        Schema::create('president_funds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('nic');
            $table->string('contact_number');
            $table->foreignId('gn_division_id')->nullable()->references('id')->on('gn_divisions');
            $table->string('status');
            $table->timestamp('submission_timestamp');
            $table->text('comment')->nullable();
            $table->string('application_code')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('president_funds');
    }
};
