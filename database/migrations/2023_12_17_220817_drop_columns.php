<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('projetos', function (Blueprint $table) {
            //
            $table->dropForeign(['projetos_fk_areas_id_foreign']);
            $table->dropIfExists('fk_area_id');
        });
        Schema::table('projeto_pre_tccs', function (Blueprint $table) {
            //
            $table->dropForeign(['projeto_pre_tccs_fk_areas_id_foreign']);
            $table->dropIfExists('fk_area_id');
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
