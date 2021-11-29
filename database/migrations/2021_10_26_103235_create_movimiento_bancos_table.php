<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientoBancosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_bancos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_banco');
            $table->date('fecha');
            $table->string('tipo');
            $table->string('razon_social')->nullable();
            $table->string('concepto');
            $table->string('num_documento')->nullable();
            $table->float('importe');
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
        Schema::dropIfExists('movimiento__bancos');
    }
}
