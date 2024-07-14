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
        Schema::create('income_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('nic');
            $table->string('contact_number');
            $table->string('purpose');
            $table->string('submitting_institute');
            $table->string('total_annual_income');
            $table->string('income_tax_number')->nullable();
            $table->string('is_samurdhi_beneficiary');
            $table->date('checked_date');
            $table->string('status');
            $table->timestamp('submission_timestamp')->useCurrent();
            $table->time('checked_time')->nullable();
            $table->text('comment')->nullable();
            $table->string('application_code');
            $table->foreignId('gn_division_id')->nullable()->references('id')->on('gn_divisions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_certificates');
    }
};
