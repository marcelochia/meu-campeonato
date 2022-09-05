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
        Schema::create('finished_championships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championship_id')->references('id')->on('championships');
            $table->foreignId('first_place_team')->references('id')->on('teams');
            $table->foreignId('second_place_team')->references('id')->on('teams');
            $table->foreignId('third_place_team')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finished_championships');
    }
};
