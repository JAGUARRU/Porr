<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('plateNumber')->unique();
            $table->string('truck_status');

            $table->string('truck_province');
            $table->string('truck_district');
            $table->string('truck_sub_district');
            $table->string('truck_postcode');

            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete();

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
        Schema::dropIfExists('trucks');
    }
}
