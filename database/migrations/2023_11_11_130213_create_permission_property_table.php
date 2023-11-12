<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_permission_id')->nullable();
            // ... other columns ...

            // Define foreign key constraint
            $table->foreign('fk_permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('SET NULL');

            $table->unsignedBigInteger('fk_role_id')->nullable();
            // ... other columns ...

            // Define foreign key constraint
            $table->foreign('fk_role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('SET NULL');
            $table->string('acao')->nullable();
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
        Schema::dropIfExists('permission_properties');
    }
}
