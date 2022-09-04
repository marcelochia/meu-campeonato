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
        Schema::table('championship_teams', function (Blueprint $table) {
            $table->dropForeign(['championship_id']);
            $table->foreign('championship_id')->references('id')->on('championships')->cascadeOnDelete()->change();
            $table->dropForeign(['team_id']);
            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete()->change();
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
};
