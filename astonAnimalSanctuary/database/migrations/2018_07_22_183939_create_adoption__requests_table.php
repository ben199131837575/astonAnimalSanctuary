<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdoptionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoption__requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('animalid');
            $table->unsignedInteger('userid');
            $table->foreign('animalid')->references('id')->on('animals');
            $table->foreign('userid')->references('id')->on('users');
            $table->string('reason', 255);
            $table->string('other_animals', 255);
            $table->enum('type', ['pending', 'accepted', 'denied'])->default('pending');
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
        Schema::dropIfExists('adoption__requests');
    }
}
