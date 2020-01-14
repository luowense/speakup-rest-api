<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JoinTableUsersTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_user', function(Blueprint $table){
           $table->bigIncrements('id');
           $table->unsignedInteger('ticket_id');
           $table->unsignedInteger('user_id');

           $table->foreign('ticket_id')->references('id')->on('tickets');
           $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
