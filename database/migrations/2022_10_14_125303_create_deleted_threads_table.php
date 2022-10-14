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
        Schema::create('deleted_threads', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('creater_id');
          $table->string('name', 30);
          $table->integer('category_id')->nullable();
          $table->timestamps();
          $table->string('update_reason', 255)->nullable();
          $table->dateTime('deleted_at')->nullable();
          $table->string('delete_reason', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deleted_threads');
    }
};
