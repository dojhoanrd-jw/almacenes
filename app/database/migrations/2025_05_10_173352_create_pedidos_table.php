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
        Schema::create('tblpedido', function (Blueprint $table) {
            $table->id('PedidoId');
            $table->unsignedBigInteger('FacturaId');
            $table->unsignedBigInteger('ArticuloId');
            $table->string('colocacion'); 
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('FacturaId')->references('FacturaId')->on('tblfactura')->onDelete('cascade');
            $table->foreign('ArticuloId')->references('ArticuloId')->on('tblarticulo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblpedido');
    }
};
