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
        Schema::create('tblfactura', function (Blueprint $table) {
            $table->id('FacturaId');
            $table->unsignedBigInteger('ClienteId');
            $table->date('fecha');
            $table->decimal('total', 10, 2);
            $table->timestamps();

            $table->foreign('ClienteId')->references('ClienteId')->on('tblcliente')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblfactura');
    }
};
