<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApresentadoToProjetoPreTccs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projeto_pre_tccs', function (Blueprint $table) {
            //
            $table->date('apresentado')->nullable();
            $table->smallInteger('tema_id')->nullable();
            // Define foreign key constraint
            $table->foreign('tema_id')
                ->references('id')
                ->on('temas')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projeto_pre_tccs', function (Blueprint $table) {
            //
            $table->dropColumn('apresentado');
            $table->dropForeign('tema_id');
            $table->dropColumn('tema_id');
        });
    }
}
