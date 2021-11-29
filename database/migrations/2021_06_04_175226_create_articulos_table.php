<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('unidad');
            $table->integer('id_bien');
            $table->string('marca');
            $table->string('ubicacion')->nullable();
            $table->string('codigo_empresa')->nullable();
            $table->string('codigo')->nullable();
            $table->bigInteger('codigo_barra')->nullable();
            $table->float('cantidad')->nullable();
            $table->float('costo')->nullable();
            $table->float('p_venta')->nullable();
            $table->float('reservado')->nullable();
            $table->float('p_ventapm')->nullable();
            $table->float('p_unitario')->nullable();
            $table->float('saldo_articulo')->nullable();

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
        Schema::dropIfExists('articulos');
    }
}
