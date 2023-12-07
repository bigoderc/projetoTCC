<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldfkAlunoIdToProjetoPreTccs extends Migration
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
            $table->smallInteger('fk_aluno_id')->nullable();
            // Define foreign key constraint
            $table->foreign('fk_aluno_id')
                ->references('id')
                ->on('alunos')
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
            $table->dropConstrainedForeignId('fk_aluno_id');
        });
    }
}
