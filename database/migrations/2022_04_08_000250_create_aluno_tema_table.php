<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlunoTemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos_tema', function (Blueprint $table) {
            $table->smallInteger('id', true);
            $table->smallInteger('fk_tema_id')->nullable()->index('FK_aluno_tema_2');
            $table->smallInteger('fk_professores_id')->nullable()->index('FK_aluno_tema_3');
            $table->smallInteger('fk_alunos_id')->nullable()->index('FK_aluno_tema_4');
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
        Schema::dropIfExists('aluno_tema');
    }
}
