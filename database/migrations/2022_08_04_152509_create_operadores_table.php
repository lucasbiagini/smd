<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agente_id');
            $table->unsignedBigInteger('processo_id');
            $table->boolean('coleta')->default(false);
            $table->boolean('retencao')->default(false);
            $table->boolean('processamento')->default(false);
            $table->boolean('compartilhamento')->default(false);
            $table->boolean('eliminacao')->default(false);
            $table->timestamps();

            $table->foreign('agente_id')
                ->references('id')
                ->on('agentes')
                ->onDelete('cascade');

            $table->foreign('processo_id')
                ->references('id')
                ->on('processos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operadores');
    }
}
