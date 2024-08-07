<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timber_cutting_permit_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('contact_number');
            $table->string('timber_seller_checked_value');
            $table->string('non_commercial_use_checked_value');
            $table->string('ownership_of_land_checked_value');
            $table->string('trees_cut_before');
            $table->string('planted_tree_count');
            $table->string('road_to_land');
            $table->string('tree_count');
            $table->string('status')->default('Submitted');
            $table->timestamp('submission_timestamp')->nullable();
            $table->date('checked_date')->nullable();
            $table->time('checked_time')->nullable();
            $table->string('comment')->nullable();
            $table->string('application_code')->unique();
            $table->foreignId('gn_division_id')->nullable()->references('id')->on('gn_divisions');
            $table->foreignId('deed_detail_id')->nullable()->references('id')->on('deed_details');
            $table->foreignId('land_detail_id')->nullable()->references('id')->on('land_details');
            $table->foreignId('boundary_id')->nullable()->references('id')->on('boundaries');
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timber_cutting_permit_applications');
    }
};
