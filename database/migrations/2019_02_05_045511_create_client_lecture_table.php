<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientLectureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lecture_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('lectures_clients',function(Blueprint $table)  {
            $table->foreign('lecture_id')->references('id')->on('lectures')->onDelete('cascade');
        });
        Schema::table('lectures_clients',function(Blueprint $table)  {
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lectures_clients');
    }
}
