<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblPY1', function (Blueprint $table) {
            $table->id('UserId');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('cedula');
            $table->string('telefono');
            $table->string('tipo_sangre');
            $table->string('rol')->default('User'); 
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
        Schema::dropIfExists('tblPY1');
    }
};
