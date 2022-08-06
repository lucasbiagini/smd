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
            $table->string('status')->default(App\Models\Processo::PENDENTE);
            $table->string('status_agentes')->default(App\Models\Processo::PENDENTE);
            $table->string('status_fluxo')->default(App\Models\Processo::PENDENTE);
            $table->string('status_escopo')->default(App\Models\Processo::PENDENTE);
            $table->string('status_finalidade')->default(App\Models\Processo::PENDENTE);
            $table->string('status_categoria_dados')->default(App\Models\Processo::PENDENTE);
            $table->string('status_frequencia')->default(App\Models\Processo::PENDENTE);
            $table->string('status_titulares')->default(App\Models\Processo::PENDENTE);
            $table->string('status_compartilhamentos')->default(App\Models\Processo::PENDENTE);
            $table->string('status_medidas')->default(App\Models\Processo::PENDENTE);
            $table->string('status_transferencias')->default(App\Models\Processo::PENDENTE);
            $table->unsignedBigInteger('controlador_id')->nullable();
            $table->unsignedBigInteger('encarregado_id')->nullable();
            $table->string('desc')->nullable();
            $table->string('abrangencia')->nullable();
            $table->string('fonte')->nullable();
            $table->string('hipotese')->nullable();
            $table->string('finalidade')->nullable();
            $table->string('previsao_legal')->nullable();
            $table->string('resultados')->nullable();
            $table->string('beneficios')->nullable();
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
