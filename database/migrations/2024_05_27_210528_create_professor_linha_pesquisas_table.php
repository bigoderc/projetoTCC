<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProfessorLinhaPesquisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professor_linha_pesquisas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id')->nullable();
            // Define foreign key constraint
            $table->foreign('professor_id')
                ->references('id')
                ->on('professores')
                ->onDelete('SET NULL');
            $table->unsignedBigInteger('linha_pesquisa_id')->nullable();
            // Define foreign key constraint
            $table->foreign('linha_pesquisa_id')
                ->references('id')
                ->on('areas')
                ->onDelete('SET NULL');
            $table->timestamps();
        });
        $professores = DB::table('professores')->get();

        // Iterando sobre cada professor
        foreach ($professores as $professor) {
            // Inserindo na tabela professor_linha_pesquisas
            DB::table('professor_linha_pesquisas')->insert([
                'professor_id' => $professor->id,
                'linha_pesquisa_id' => $professor->fk_areas_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professor_linha_pesquisas');
    }
}
