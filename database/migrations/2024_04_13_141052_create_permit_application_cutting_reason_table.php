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
        Schema::create('permit_application_cutting_reason', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permit_application_id')->references('id')->on('timber_cutting_permit_applications');
            $table->foreignId('cutting_reason_id')->references('id')->on('tree_cutting_reasons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permit_application_cutting_reason');
    }
};
