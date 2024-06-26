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
        Schema::create('timber_details', function (Blueprint $table) {
            $table->id();
            $table->string('timber_type');
            $table->string('length');
            $table->string('width');
            $table->string('piece_count');
            $table->foreignId('timber_transporting_permit_application_id')->nullable()->references('id')->on('timber_transporting_applications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timber_details');
    }
};
