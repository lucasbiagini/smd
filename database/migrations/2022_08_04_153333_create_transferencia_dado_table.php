<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferenciaDadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencia_dado', function (Blueprint $table) {
            $table->unsignedBigInteger('dado_id');
            $table->unsignedBigInteger('transferencia_id');
            $table->timestamps();

            $table->index(['dado_id', 'transferencia_id']);

            $table->foreign('dado_id')
                ->references('id')
                ->on('dados')
                ->onDelete('cascade');

            $table->foreign('transferencia_id')
                ->references('id')
                ->on('transferencias')
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
        Schema::dropIfExists('transferencia_dado');
    }
}
