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
            $table->string('application_code')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('contact_number');
            $table->string('reason_to_transport');
            $table->string('start_point');
            $table->string('destination');
            $table->integer('cost_per_animal');
            $table->date('issued_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->date('checked_date')->nullable();
            $table->string('status')->default('Submitted');
            $table->timestamp('submission_timestamp')->nullable();
            $table->string('comment')->nullable();
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
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
