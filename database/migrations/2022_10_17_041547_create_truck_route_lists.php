<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckRouteLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_route_lists', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('truck_route_id')->unsigned()->index();
            $table->foreign('truck_route_id')->references('id')->on('truck_routes')->onDelete('cascade')->onUpdate('cascade');;
            
            $table->string('order_id')->unique()->index();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');;
            $table->unique(['order_id', 'truck_route_id']);

            $table->timestamp('completedDate')->nullable()->default(null);

            $table->integer('route_list_status')->default(0);

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
        Schema::dropIfExists('truck_route_lists');
    }
}
