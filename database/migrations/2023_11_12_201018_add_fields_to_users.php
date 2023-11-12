<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropForeign(['user_id_created']);
            $table->dropForeign(['user_id_updated']);
            $table->dropColumn(['user_id_created', 'user_id_updated']);
        });
    }
}
