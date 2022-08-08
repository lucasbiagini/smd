<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompartilhamentoDadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compartilhamento_dado', function (Blueprint $table) {
            $table->unsignedBigInteger('dado_id');
            $table->unsignedBigInteger('compartilhamento_id');
            $table->timestamps();

            $table->index(['dado_id', 'compartilhamento_id']);

            $table->foreign('dado_id')
                ->references('id')
                ->on('dados')
                ->onDelete('cascade');

            $table->foreign('compartilhamento_id')
                ->references('id')
                ->on('compartilhamentos')
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
        Schema::dropIfExists('compartilhamento_dado');
    }
}
