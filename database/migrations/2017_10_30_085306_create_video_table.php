<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('link')->nullable();
            $table->text('download1')->nullable();
            $table->text('download2')->nullable();
            $table->text('image')->nullable();
            $table->text('preview')->nullable();
            $table->text('code')->nullable();
            $table->text('size')->nullable();
            $table->text('time')->nullable();
            $table->text('file')->nullable();
            $table->text('released')->nullable();
            $table->text('width')->nullable();
            $table->text('studio')->nullable();
            $table->text('actors')->nullable();
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
        Schema::dropIfExists('video');
    }
}
