<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_lists', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('order_route_id')->unsigned()->index();
            $table->foreign('order_route_id')->references('id')->on('order_routes')->onDelete('cascade')->onUpdate('cascade');;

            $table->string('product_id')->index();
            $table->integer('qty');

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
        Schema::dropIfExists('route_lists');
    }
}
