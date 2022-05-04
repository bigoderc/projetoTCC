<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Projeto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('projetos', function (Blueprint $table) {
            $table->smallInteger('id', true);
            $table->string('nome', 120)->nullable();
            $table->string('projeto', 60)->nullable();
            $table->string('instituicao',120)->nullable();
            $table->date('apresentacao')->nullable();
            $table->smallInteger('fk_professores_id')->nullable();
            $table->foreign(['fk_professores_id'], 'FK_professores')->references(['id'])->on('professores');
            
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
        Schema::dropIfExists('projetos');
    }
}
