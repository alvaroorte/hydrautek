<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('num_coti');
            $table->integer('id_bien');
            $table->integer('id_articulo');
            $table->float('cantidad');
            $table->string('codigo_coti')->nullable();
            $table->string('detalle')->nullable();
            $table->bigInteger('nit_cliente')->nullable();
            $table->string('cliente')->nullable();
            $table->bigInteger('id_cliente')->nullable();
            $table->bigInteger('validez');
            $table->float('p_venta');
            $table->float('sub_total');
            $table->float('total');
            $table->float('descuento');
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
        Schema::dropIfExists('cotizacions');
    }
}
