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
        Schema::create('tblarticulo', function (Blueprint $table) {
            $table->id('ArticuloId');
            $table->string('codigo_barra')->unique();
            $table->text('descripcion');
            $table->string('fabricante');
            $table->string('nombre_articulo');
            $table->decimal('precio', 10, 2);
            $table->integer('stock');
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
        Schema::dropIfExists('tblarticulo');
    }
};
