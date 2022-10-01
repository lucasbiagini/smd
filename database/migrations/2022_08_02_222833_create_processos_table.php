<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ref')->nullable();
            $table->unsignedBigInteger('setor_id');
            $table->unsignedBigInteger('controlador_id')->nullable();
            $table->unsignedBigInteger('encarregado_id')->nullable();
            $table->longText('desc')->nullable();
            $table->longText('abrangencia')->nullable();
            $table->longText('fonte')->nullable();
            $table->string('hipotese')->nullable();
            $table->longText('finalidade')->nullable();
            $table->longText('previsao_legal')->nullable();
            $table->longText('resultados')->nullable();
            $table->longText('beneficios')->nullable();
            $table->string('frequencia')->nullable();
            $table->string('quantidade')->nullable();
            $table->boolean('criancas')->nullable();
            $table->boolean('vulneraveis')->nullable();
            $table->timestamps();

            $table->foreign('setor_id')
                ->references('id')
                ->on('setores')
                ->onDelete('cascade');

            $table->foreign('controlador_id')
                ->references('id')
                ->on('agentes')
                ->onDelete('cascade');

            $table->foreign('encarregado_id')
                ->references('id')
                ->on('agentes')
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
        Schema::dropIfExists('processos');
    }
}
