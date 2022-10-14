<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('comment_id');
          $table->unsignedBigInteger('reporter_id');

          $table->foreign('comment_id')->references('id')->on('comments');
          $table->foreign('reporter_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
