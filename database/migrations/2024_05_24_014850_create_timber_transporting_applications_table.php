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
        Schema::create('timber_transporting_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('contact_number');
            $table->string('address_of_timber');
            $table->string('is_timber_bought_checked_value');
            $table->string('receipt_no');
            $table->date('bought_date');
            $table->string('road_to_timber_location');
            $table->string('is_timber_private_land_checked_value');
            $table->string('end_location');
            $table->string('route');
            $table->date('timber_transport_date');
            $table->string('plate_number');
            $table->string('total_pieces');
            $table->foreignId('private_land_id')->nullable()->references('id')->on('private_lands');
            $table->foreignId('boundary_id')->nullable()->references('id')->on('boundaries');
            $table->foreignId('
        gn_division_id')->nullable()->references('id')->on('gn_divisions');
            $table->foreignId('timber_detail_id')->nullable()->references('id')->on('timber_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timber_transporting_applications');
    }
};
