<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetoPreTccAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projeto_pre_tcc_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_projeto_pre_tcc_id')->nullable();
            // Define foreign key constraint
            $table->foreign('fk_projeto_pre_tcc_id')
                ->references('id')
                ->on('projeto_pre_tccs')
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
        Schema::dropIfExists('projeto_pre_tcc_areas');
    }
}
