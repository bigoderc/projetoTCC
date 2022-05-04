<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAlunos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('instituicao', 120)->nullable();
            $table->string('curso', 100)->nullable();
            $table->char('matriculado', 1)->default('S')->nullable();
            $table->string('periodo', 10)->nullable();
            $table->string('turma', 100)->nullable();
            $table->string('ingresso', 10)->nullable();
            $table->string('email')->nullable();
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
