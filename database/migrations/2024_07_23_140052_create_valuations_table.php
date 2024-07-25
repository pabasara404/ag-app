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
        Schema::create('valuations', function (Blueprint $table) {
            $table->id(); $table->string('application_code');
            $table->string('name');
            $table->string('address');
            $table->decimal('valuation_amount', 10, 2);
            $table->text('reason');
            $table->string('land_deed_number');
            $table->string('to_north');
            $table->string('to_south');
            $table->string('to_east');
            $table->string('to_west');
            $table->string('size');
            $table->string('length');
            $table->string('width');
            $table->string('notary_officer_name');
            $table->string('plan_number');
            $table->date('plan_date');
            $table->string('land_name');
            $table->string('status');
            $table->timestamp('submission_timestamp');
            $table->date('checked_date');
            $table->text('comment');
            $table->foreignId('gn_division_id')->nullable()->references('id')->on('gn_divisions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valuations');
    }
};
