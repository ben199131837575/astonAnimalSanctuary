<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdoptedAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adopted_animals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('animalid');
            $table->unsignedInteger('userid');
            $table->foreign('animalid')->references('id')->on('animals')->unique();
            $table->foreign('userid')->references('id')->on('users');
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
        Schema::dropIfExists('adopted_animals');
    }
}
