<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id', 32)->primary();
            $table->string('prod_name');
            $table->float('prod_price', 8, 2);
            $table->string('prod_type_name');
            $table->text('prod_detail')->nullable();
            $table->timestamps();

            $table->unique(['prod_name', 'prod_type_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
