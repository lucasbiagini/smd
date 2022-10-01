<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompartilhamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compartilhamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('processo_id');
            $table->string('nome_insituicao')->nullable();
            $table->longText('finalidade')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('compartilhamentos');
    }
}
