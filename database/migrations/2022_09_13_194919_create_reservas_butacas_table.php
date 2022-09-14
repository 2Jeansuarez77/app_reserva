<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasButacasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas_butacas', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->integer('fila');
            $table->integer('columna');
            $table->bigInteger('reserva_id')->unsigned(); 

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('reserva_id')->references('id')->on('reservas')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas_butacas');
    }
}
