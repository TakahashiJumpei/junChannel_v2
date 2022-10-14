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
        Schema::create('deleted_comments', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('commenter_id');
          $table->integer('guests_commenter_id');
          $table->integer('thread_id');
          $table->integer('comment_number');
          $table->string('content', 1000);
          $table->timestamps();
          $table->dateTime('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deleted_comments');
    }
};
