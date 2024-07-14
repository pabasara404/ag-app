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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no');
            $table->string('identification_no');
            $table->string('species');
            $table->string('breed');
            $table->string('age');
            $table->string('sex');
            $table->string('color');
            $table->string('specific_marks');
            $table->string('health_certificate_no');
            $table->string('vehicle_registration_no');
            $table->foreignId('animal_transportation_id')->references('id')->on('animal_transportations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
