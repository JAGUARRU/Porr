<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_routes', function (Blueprint $table) 
        {
            $table->id();
            
            $table->string('truck_id')->nullable()->index();
            $table->string('truck_driver');
            $table->string('truck_plate');
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('set null');

            $table->string('order_id')->index();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');;

            $table->integer('status');

            $table->timestamp('transportDate');
            $table->timestamp('confirmDate')->nullable()->default(null);
 
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
        Schema::dropIfExists('order_routes');
    }
}
