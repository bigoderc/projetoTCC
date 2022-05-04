<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAlunoTemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aluno_tema', function (Blueprint $table) {
            $table->foreign(['fk_professores_id'], 'FK_aluno_tema_3')->references(['id'])->on('professores')->onDelete('SET NULL');
            $table->foreign(['fk_tema_id'], 'FK_aluno_tema_2')->references(['id'])->on('tema');
            $table->foreign(['fk_alunos_id'], 'FK_aluno_tema_4')->references(['id'])->on('alunos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aluno_tema', function (Blueprint $table) {
            $table->dropForeign('FK_aluno_tema_3');
            $table->dropForeign('FK_aluno_tema_2');
            $table->dropForeign('FK_aluno_tema_4');
        });
    }
}
