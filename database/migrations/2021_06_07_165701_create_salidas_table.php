<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_venta');
            $table->date('fecha');
            $table->integer('id_bien');
            $table->integer('id_articulo');
            $table->float('cantidad');
            $table->string('codigo_cli')->nullable();
            $table->bigInteger('nit_cliente')->nullable();
            $table->string('cliente')->nullable();
            $table->string('detalle')->nullable();
            $table->integer('id_cliente')->nullable();
            $table->boolean('scfactura');
            $table->string('sccredito');
            $table->integer('id_banco')->nullable();
            $table->bigInteger('num_factura')->nullable();
            $table->float('costo_s')->nullable();
            $table->float('p_venta');
            $table->float('sub_total');
            $table->float('total');
            $table->float('descuento')->nullable();
            $table->integer('identificador');
            $table->integer('num_venta');
            $table->boolean('estado')->nullable();
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
        Schema::dropIfExists('salidas');
    }
}
