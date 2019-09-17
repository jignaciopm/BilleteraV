<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->date('fecha');
            $table->longText('concepto');
            $table->enum('tipo',['+','-']);
            $table->string('monto');
            $table->enum('medio',['efectivo','transferencia']);
            $table->enum('banco',['BanPan','Chase', 'BofA'])->nullable();
            $table->enum('gasto',['Hogar','Carro', 'Medicinas', 'Ayuda familiar', 'Salida', 'Comisiones', 'Cambios', 'Prestamos', 'Otros'])->nullable();
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
        Schema::dropIfExists('movimientos');
    }
}
