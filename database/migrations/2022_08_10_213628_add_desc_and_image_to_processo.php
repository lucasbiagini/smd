<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescAndImageToProcesso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processos', function (Blueprint $table) {
            $table->longText('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_filename')->nullable();
            $table->string('image_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processos', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('image_path');
            $table->dropColumn('image_filename');
            $table->dropColumn('image_type');
        });
    }
}
