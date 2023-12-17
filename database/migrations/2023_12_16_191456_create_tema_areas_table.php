<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemaAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tema_areas', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('fk_tema_id')->nullable();
            // Define foreign key constraint
            $table->foreign('fk_tema_id')
                ->references('id')
                ->on('temas')
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
        Schema::dropIfExists('tema_areas');
    }
}
