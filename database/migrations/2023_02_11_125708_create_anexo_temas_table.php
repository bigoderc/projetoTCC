<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexoTemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexo_temas', function (Blueprint $table) {
            $table->id();
            $table->string('arquivo')->nullable();
            $table->smallInteger('fk_tema_id');
            $table->foreign(['fk_tema_id'], 'FK_temas_2')->references(['id'])->on('temas')->onDelete('CASCADE');
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
        Schema::dropIfExists('anexo_temas');
    }
}
