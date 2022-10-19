<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) 
        {

            $table->string('id')->primary();
       
            $table->string('retail_id')->nullable()->index();
            $table->string('retail_name');
            $table->string('retail_province');
            $table->string('retail_district');
            $table->string('retail_sub_district');
            $table->string('retail_postcode');

            $table->timestamp('order_date')->useCurrent();
            $table->timestamp('order_transportDate')->nullable()->default(null);
            
            $table->string('order_status');
            $table->boolean('order_cancelled')->default(false);
            $table->dateTime('order_cancelDateTime', $precision = 0)->nullable()->default(null);

            $table->float('order_total', 8, 2)->default(0.0);

            $table->foreign('retail_id')->references('id')->on('retails')->onDelete('set null');

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
        Schema::dropIfExists('orders');
    }
}
