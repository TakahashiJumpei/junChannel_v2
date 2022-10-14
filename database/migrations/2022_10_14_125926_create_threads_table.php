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
        Schema::create('threads', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('creater_id')->index();
          $table->string('name', 30)->index();
          $table->string('explanation', 1000)->nullable();
          $table->unsignedBigInteger('category_id')->nullable()->index();
          $table->timestamps();
          $table->string('update_reason', 255)->nullable();

          $table->foreign('creater_id')->references('id')->on('users');
          $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
};
