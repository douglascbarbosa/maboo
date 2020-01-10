<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('author', 70);
            $table->integer('pages')->unsigned();
            $table->integer('rate')->nullable();
            $table->integer('marker')->default(1)->unsigned();
            $table->boolean('future_read')->default(false);
            $table->date('planning_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->string('photo_id')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('books');
    }
}
