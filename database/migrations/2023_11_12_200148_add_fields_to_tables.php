<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tabelas = ['alunos', 'alunos_tema', 'areas','cargos', 'cursos', 'especialidades','graus', 'professores', 'temas','turmas'];

        foreach ($tabelas as $tabela) {
            Schema::table($tabela, function (Blueprint $table) {
                $table->foreignId('user_id_created')->nullable()->references('id')->on('users')->constrained()->restrictOnDelete();
                $table->foreignId('user_id_updated')->nullable()->references('id')->on('users')->constrained()->restrictOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tabelas = ['alunos', 'alunos_temas', 'areas','cargos', 'cursos', 'especialidades','graus', 'professores', 'temas','turmas'];

        foreach ($tabelas as $tabela) {
            Schema::table($tabela, function (Blueprint $table) {
                $table->dropForeign(['user_id_created']);
                $table->dropForeign(['user_id_updated']);
                $table->dropColumn(['user_id_created', 'user_id_updated']);
            });
        }
    }
}
