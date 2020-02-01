<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGameIdForeignKeyToCellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cells', function (Blueprint $table) {
            $table->foreign('game_id')
                  ->references('id')
                  ->on('games')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cells', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
        });
    }
}
