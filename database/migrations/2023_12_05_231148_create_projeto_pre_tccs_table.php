<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetoPreTccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projeto_pre_tccs', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 120)->nullable();
            $table->string('projeto', 60)->nullable();
            $table->string('instituicao',120)->nullable();
            $table->smallInteger('fk_professores_id')->nullable();
            $table->foreign(['fk_professores_id'], 'FK_professores')->references(['id'])->on('professores');
            $table->smallInteger('fk_areas_id')->nullable();
            // Define foreign key constraint
            $table->foreign('fk_areas_id')
                ->references('id')
                ->on('areas')
                ->onDelete('SET NULL');
            $table->softDeletes();
            $table->foreignId('user_id_created')->nullable()->references('id')->on('users')->constrained()->restrictOnDelete();
            $table->foreignId('user_id_updated')->nullable()->references('id')->on('users')->constrained()->restrictOnDelete();
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
        Schema::dropIfExists('projeto_pre_tccs');
    }
}
