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
        Schema::create('mahapola_file_detail', function (Blueprint $table) {
            $table->foreignId('mahapola_id')->references('id')->on('mahapolas');
            $table->foreignId('file_detail_id')->references('id')->on('file_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahapola_file_detail');
    }
};
