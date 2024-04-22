<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetoAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projeto_areas', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('fk_projeto_id')->nullable();
            // Define foreign key constraint
            $table->foreign('fk_projeto_id')
                ->references('id')
                ->on('projetos')
                ->onDelete('SET NULL');
            $table->smallInteger('fk_area_id')->nullable();
            // Define foreign key constraint
            $table->foreign('fk_area_id')
                ->references('id')
                ->on('areas')
                ->onDelete('SET NULL');
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
        Schema::dropIfExists('projeto_areas');
    }
}
