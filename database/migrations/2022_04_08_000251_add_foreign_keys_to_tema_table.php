<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tema', function (Blueprint $table) {
            $table->foreign(['fk_areas_id'], 'FK_tema_2')->references(['id'])->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tema', function (Blueprint $table) {
            $table->dropForeign('FK_tema_2');
        });
    }
}
