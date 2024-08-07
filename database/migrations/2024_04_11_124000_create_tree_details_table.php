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
        Schema::create('tree_details', function (Blueprint $table) {
            $table->id();
            $table->string('sub_no');
            $table->string('type');
            $table->string('height');
            $table->string('girth');
            $table->string('reproducibility');
            $table->string('age');
            $table->foreignId('timber_cutting_permit_application_id')->nullable()->references('id')->on('timber_cutting_permit_applications');
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
        Schema::dropIfExists('tree_details');
    }
};
