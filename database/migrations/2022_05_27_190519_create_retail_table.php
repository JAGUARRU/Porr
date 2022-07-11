<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retails', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('retail_name');
            $table->string('retail_address');
            $table->string('retail_province');
            $table->string('retail_district');
            $table->string('retail_sub_district');
            $table->string('retail_postcode');
            $table->string('retail_phone');
            $table->string('retail_contact');
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
        Schema::dropIfExists('retails');
    }
}
