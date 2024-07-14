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
        Schema::create('animal_transportations', function (Blueprint $table) {
            $table->id();
            $table->string('application_code');
            $table->string('name');
            $table->string('address');
            $table->string('contact_number');
            $table->string('reason_to_transport');
            $table->string('start_point');
            $table->string('destination');
            $table->integer('cost_per_animal');
            $table->date('issued_date');
            $table->date('expire_date');
            $table->date('checked_date');
            $table->string('status');
            $table->timestamp('submission_timestamp');
            $table->time('checked_time');
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_transportations');
    }
};
