<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('position_user', function (Blueprint $table) {
            $table->foreignId('position_id')->references('id')->on('positions')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('position_user');
    }
}
