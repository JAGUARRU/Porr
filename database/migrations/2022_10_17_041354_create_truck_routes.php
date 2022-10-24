<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckRoutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_routes', function (Blueprint $table) {
            $table->id();

            $table->string('truck_id')->nullable()->index();
            $table->string('truck_driver');
            $table->string('truck_plateNumber');
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('set null');

            $table->integer('route_status')->default(0);

            $table->timestamp('transportDate')->nullable()->default(\Carbon\Carbon::now()->add(1, 'day')->format('Y-m-d H:i:s'));
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
        Schema::dropIfExists('truck_routes');
    }
}
