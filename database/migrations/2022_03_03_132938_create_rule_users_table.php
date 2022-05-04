<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_roles_id')->nullable();
            $table->unsignedBigInteger('fk_users_id')->nullable();
            $table->foreign(['fk_roles_id'], 'fk_roles')->references(['id'])->on('roles')->onDelete('CASCADE');
            $table->foreign(['fk_users_id'], 'fk_users')->references(['id'])->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('role_users');
    }
}
