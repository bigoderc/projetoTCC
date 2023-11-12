<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProjetos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projetos', function (Blueprint $table) {
            //
            $table->smallInteger('fk_areas_id')->nullable();
            // Define foreign key constraint
            $table->foreign('fk_areas_id')
                ->references('id')
                ->on('areas')
                ->onDelete('SET NULL');
            $table->softDeletes();
            $table->foreignId('user_id_created')->nullable()->references('id')->on('users')->constrained()->restrictOnDelete();
            $table->foreignId('user_id_updated')->nullable()->references('id')->on('users')->constrained()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projetos', function (Blueprint $table) {
            //
            $table->dropConstrainedForeignId(['fk_areas_id','user_id_created','user_id_updated']);
        });
    }
}
