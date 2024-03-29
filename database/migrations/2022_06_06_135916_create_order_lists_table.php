<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lists', function (Blueprint $table) 
        {
            $table->id();
            $table->string('product_id')->index();
            $table->string('product_name');

            $table->integer('qty');
            $table->float('price', 8, 2);
            $table->float('total', 8, 2);
            $table->timestamps();

            $table->string('order_id')->index();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');;
            $table->unique(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('order_lists', function (Blueprint $table) {
            $table->dropForeign('order_lists_order_id_foreign');
            $table->dropIndex('order_lists_order_id_index');
            $table->dropColumn('order_id');
        });*/

        Schema::dropIfExists('order_lists');
    }
}
