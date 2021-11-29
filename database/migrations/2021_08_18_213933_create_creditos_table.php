<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->date('fecha');
            $table->integer('identificador');
            $table->string('codigo');
            $table->integer('plazo');
            $table->integer('id_cliente')->nullable();
            $table->integer('id_proveedor')->nullable();
            $table->float('total');
            $table->float('saldo');
            $table->boolean('estado');
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
        Schema::dropIfExists('creditos');
    }
}
