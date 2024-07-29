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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('payment_type');
            $table->string('application_code');
            $table->decimal('amount', 10, 2);
            $table->string('receipt_no');
            $table->date('paid_date');
            $table->string('contact_number');
            $table->string('nic');
            $table->string('file_path')->nullable();
            $table->unsignedBigInteger('application_id');
            $table->string('application_table');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
