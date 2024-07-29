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
        Schema::create('firms', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('nature');
            $table->string('principal_place');
            $table->decimal('initial_capital', 15, 2);
            $table->date('start_date');
            $table->boolean('is_other_business_value')->default(false);
            $table->boolean('is_other_occupation_value')->default(false);
            $table->string('ownership_of_land_checked_value');
            $table->string('status')->default('Submitted');
            $table->timestamp('submission_timestamp')->nullable();
            $table->string('application_code')->unique();
            $table->date('checked_date')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('gn_division_id')->nullable()->references('id')->on('gn_divisions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firms');
    }
};
