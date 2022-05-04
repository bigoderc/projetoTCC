<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_permission_id')->nullable();
            $table->unsignedBigInteger('fk_roles_id')->nullable();
            $table->foreign(['fk_roles_id'], 'fk_roles1')->references(['id'])->on('roles')->onDelete('SET NULL');
            $table->foreign(['fk_permission_id'], 'fk_permission')->references(['id'])->on('permissions')->onDelete('SET NULL');
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
        Schema::dropIfExists('permission_roles');
    }
}
