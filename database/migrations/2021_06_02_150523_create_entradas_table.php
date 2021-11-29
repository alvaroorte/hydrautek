<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('num_entrada');
            $table->string('detalle')->nullable();
            $table->integer('id_bien');
            $table->integer('id_articulo');
            $table->float('cantidad');
            $table->float('p_unitario');
            $table->float('costo_e');
            $table->string('proveedor')->nullable();
            $table->bigInteger('nit_proveedor')->nullable();
            $table->integer('id_proveedor')->nullable();
            $table->float('p_total');
            $table->float('total');
            $table->bigInteger('num_factura')->nullable();
            $table->boolean('csfactura');
            $table->string('cscredito');
            $table->integer('id_banco')->nullable();
            $table->string('codigo')->nullable();
            $table->integer('identificador');

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
        Schema::dropIfExists('entradas');
    }
}
