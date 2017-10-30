<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('notifications',function(Blueprint $table){
            $table->increments('id');
            $table->text('content');
            $table->string('type');
            $table->integer('notifier')->unsigned();
            $table->foreign('notifier')->references('id')->on('users');
            $table->boolean('seen')->default(false);
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
         Schema::drop('notifications');
    }
}
